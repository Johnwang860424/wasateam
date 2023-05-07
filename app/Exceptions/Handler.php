<?php

/** 這是 Laravel 應用程式中的一個 exception handler，在程式發生錯誤時會負責處理與報告錯誤。在這個類別中，$dontFlash 屬性定義了在 validation exception 中不應該被暫存到 session 中的 input 名稱，避免出現安全問題。register 方法則設置了要處理哪些類型的 exception，例如這個方法中沒有設置任何處理方法，因此所有的 exception 都不會被處理，只是簡單地報告錯誤。如果要對某些類型的 exception 做特別的處理，可以透過這個方法來設置相應的處理 callback。 **/

namespace App\Exceptions;

use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;
use Throwable;

class Handler extends ExceptionHandler
{
    /**
     * The list of the inputs that are never flashed to the session on validation exceptions.
     *
     * @var array<int, string>
     */
    protected $dontFlash = [
        'current_password',
        'password',
        'password_confirmation',
    ];

    /**
     * Register the exception handling callbacks for the application.
     */
    public function register(): void
    {
        $this->reportable(function (Throwable $e) {
            //
        });
    }
}
