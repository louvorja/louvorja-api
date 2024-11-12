<?php

namespace App\Models;

use App\Models\Log;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;
use App\Services\TelegramService;

class BaseModel extends Model
{
    public static function boot()
    {
        parent::boot();

        static::created(function ($model) {
            self::logChanges($model, 'insert', [], $model->getAttributes());
        });

        static::updated(function ($model) {
            $oldValues = $model->getOriginal();
            $newValues = $model->getAttributes();
            self::logChanges($model, 'update', $oldValues, $newValues);
        });

        static::deleted(function ($model) {
            self::logChanges($model, 'delete', $model->getAttributes(), []);
        });
    }

    private static function logChanges($model, $action, $oldValues, $newValues)
    {
        if ($model->getTable() == "configs") {
            return;
        }

        $telegram_log = "";
        if ($action === 'update') {
            $changedValues = [];
            $changedOldValues = [];

            foreach ($newValues as $key => $newValue) {
                if (array_key_exists($key, $oldValues) && $oldValues[$key] !== $newValue) {
                    $changedValues[$key] = $newValue;
                    $changedOldValues[$key] = $oldValues[$key];

                    $telegram_log .= "🟡 <b>{$key}</b>\n";
                    $telegram_log .= "<blockquote><s>{$oldValues[$key]}</s></blockquote>\n";
                    $telegram_log .= "<blockquote>{$newValue}</blockquote>\n";
                } else {
                    $telegram_log .= "⚪ <b>{$key}</b>\n";
                    $telegram_log .= "<blockquote>{$newValue}</blockquote>\n";
                }
                $telegram_log .= "\n";
            }

            if (empty($changedValues)) {
                return;
            }

            $oldValues = $changedOldValues;
            $newValues = $changedValues;
        } elseif ($action === 'insert') {
            foreach ($newValues as $key => $value) {
                $telegram_log .= "✔️ <b>{$key}</b>\n";
                $telegram_log .= "<blockquote>{$value}</blockquote>\n\n";
            }
        } else {
            foreach ($oldValues as $key => $value) {
                $telegram_log .=  "❌ <b>{$key}</b>\n";
                $telegram_log .= "<blockquote>{$value}</blockquote>\n\n";
            }
        }

        Log::create([
            'table' => $model->getTable(),
            'action' => $action,
            'old_values' => $oldValues,
            'new_values' => $newValues,
            'user_id' => Auth::check() ? Auth::user()->id : null,
            'user' => Auth::check() ? Auth::user() : null,
        ]);


        $telegramService = new TelegramService();

        $message = "";
        $message .= "<b>" . ($action == "insert"
            ? "🟩🟩🟩 Novo Registro 🟩🟩🟩"
            : (
                $action == "update"
                ? "🟨🟨🟨 Registro Alterado 🟨🟨🟨"
                : "🟥🟥🟥 Registro Removido 🟥🟥🟥"
            )
        ) . "</b>\n";
        $message .= "\n";
        $message .= "🏷️ {$model->getTable()}\n";
        $message .= ($action == "insert" ? "🟢" : ($action == "update" ? "🟡" : "🔴")) . " {$action}\n";
        $message .= "👤 " . (Auth::check() ? Auth::user()->name : 'Desconhecido') . "\n";
        $message .= "\n";
        $message .= "{$telegram_log}\n";
        $message .= "<b>Resumo:</b>\n";
        $message .= "Antes: <pre>" . json_encode($oldValues, JSON_PRETTY_PRINT) . "</pre>\n\n";
        $message .= "Depois: <pre>" . json_encode($newValues, JSON_PRETTY_PRINT) . "</pre>\n\n";
        $message .= "Usuário: <pre>" . json_encode(Auth::user(), JSON_PRETTY_PRINT) . "</pre>\n\n";

        $telegramService->sendMessage($message);
    }
}
