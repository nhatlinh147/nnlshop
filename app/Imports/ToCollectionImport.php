<?php

namespace App\Imports;

use Throwable;
use Illuminate\Support\Str;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Validator;
use Maatwebsite\Excel\Validators\Failure;
use Illuminate\Support\Facades\Notification;
use Maatwebsite\Excel\Concerns\SkipsOnError;
use Maatwebsite\Excel\Concerns\ToCollection;
use Illuminate\Validation\ValidationException;
use Maatwebsite\Excel\Concerns\SkipsOnFailure;
use Maatwebsite\Excel\Concerns\WithValidation;
use App\Imports\Exports\FailureExport;
// use ...\Contracts\NotifiesUserOnFailure;
use ...\Notifications\FailureNotification;

abstract class ToCollectionImport implements ToCollection
{
    /**
     * Set additional user resolve callback.
     *
     * @var \Illuminate\Support\Collection
     */
    protected static $additionalUsersCallback;

    abstract public function processImport(Collection $rows);

    abstract public function rules(): array;

    abstract public function getUser();

    /**
     * @param Collection $rows
     */
    public function collection(Collection $rows)
    {
        if ($this instanceof WithValidation) {
            $rows = $this->validate($rows);
        }

        try {
            $this->processImport($rows);
        } catch (Throwable $e) {
            $this->recordOrThrowErrors($e);
        }

        if ($this->failures()->count() > 0) {
            $name = Str::random(16) . now()->format('Y-M-d');
            $path = config('nova-import-card.import_failures_path') . $name . '.xlsx';

            (new FailureExport($this->failures()))->store($path);

            // if ($this instanceof NotifiesUserOnFailure) {
            //     $this->notifyUsers($name);
            // }
        }

        if ($this->errors()->count() > 0) {
            \Log::error($this->errors());
        }
    }

    /**
     * Validate given collection data.
     *
     * @param Collection $rows
     *
     * @throws ValidationException
     *
     * @return Collection
     */
    protected function validate(Collection $rows)
    {
        $validator = Validator::make($rows->toArray(), $this->rules());

        if (! $validator->fails()) {
            return $rows;
        }

        if ($this instanceof SkipsOnFailure) {
            $this->onFailure(
                ...$this->collectErrors($validator, $rows)
            );

            $keysCausingFailure = collect($validator->errors()->keys())->map(function ($key) {
                return Str::before($key, '.');
            })
            ->values()
            ->toArray();

            return $rows->except($keysCausingFailure);
        }

        throw new ValidationException($validator);
    }

    /**
     * Get all validation errors.
     *
     * @param $validator
     * @param Collection $rows
     *
     * @return array
     */
    protected function collectErrors($validator, Collection $rows)
    {
        $failures = [];

        foreach ($validator->errors()->messages() as $attribute => $messages) {
            $row = strtok($attribute, '.');

            $attributeName = strtok('');
            $attributeName = $attributeName;

            $failures[] = new Failure(
                $row,
                $attributeName,
                str_replace($attribute, $attributeName, $messages),
                $rows->toArray()[$row]
            );
        }

        return $failures;
    }

    /**
     * Records an error or throws its exception.
     *
     * @param Throwable $error
     *
     * @throws \Exception
     */
    protected function recordOrThrowErrors(Throwable $error)
    {
        if ($this instanceof SkipsOnError) {
            return $this->onError($error);
        }

        throw $error;
    }

    /**
     * Notify all users.
     *
     * @param string $name
     */
    public function notifyUsers($name)
    {
        $users = ! static::$additionalUsersCallback
            ? collect($this->getUser())
            : call_user_func(static::$additionalUsersCallback, $this->getUser());

        Notification::send($users, new FailureNotification($name));
    }

    /**
     * Set additional users callback.
     *
     * @param \Callable $callback
     *
     * @return self
     */
    public static function additionalUsers($callback)
    {
        static::$additionalUsersCallback = $callback;
    }
}