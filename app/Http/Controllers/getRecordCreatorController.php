<?php

namespace App\Http\Controllers;

use Spatie\Activitylog\Models\Activity;


class getRecordCreatorController extends Controller
{

    public function getRecordCreator($modelType, $recordId, $propertyId = null)
    {
        $modelClass = 'App\\Models\\' . $modelType;

        // Try to find creation activity
        $creationActivity = Activity::where(function ($query) use ($modelClass, $recordId, $propertyId) {
            // Method 1: Direct subject match
            $query->where('subject_type', $modelClass)
                ->where('subject_id', $recordId);

            // Method 2: Search in properties JSON
            $query->orWhere(function ($q) use ($propertyId, $recordId) {
                $q->where('properties', 'like', '%"' . $propertyId . '":' . $recordId . '%')
                    ->orWhere('properties', 'like', '%"' . $propertyId . '":"' . $recordId . '"%')
                    ->orWhere('properties', 'like', '%' . $propertyId . '":' . $recordId . '%')
                    ->orWhere('properties', 'like', '%' . $propertyId . '": "' . $recordId . '"%')
                    ->orWhereRaw('JSON_EXTRACT(properties, "$.' . $propertyId . '") = ?', [$recordId])
                    ->orWhereRaw('JSON_EXTRACT(properties, "$.attributes.' . $propertyId . '") = ?', [$recordId])
                    ->orWhereRaw('JSON_EXTRACT(properties, "$.after.' . $propertyId . '") = ?', [$recordId])
                    ->orWhereRaw('JSON_EXTRACT(properties, "$.before.' . $propertyId . '") = ?', [$recordId]);
            });
        })
            ->where(function ($query) {
                $query->where('description', 'LIKE', '%Created%')
                    ->orWhere('description', 'LIKE', '%created%')
                    ->orWhere('description', 'LIKE', '%create%')
                    ->orWhere('event', 'created');
            })
            ->latest()
            ->first();

        // If still not found, try without the creation filter
        if (!$creationActivity) {
            $creationActivity = Activity::where(function ($query) use ($modelClass, $recordId, $propertyId) {
                $query->where('subject_type', $modelClass)
                    ->where('subject_id', $recordId)
                    ->orWhere(function ($q) use ($propertyId, $recordId) {
                        $q->where('properties', 'like', '%"' . $propertyId . '":' . $recordId . '%')
                            ->orWhere('properties', 'like', '%' . $propertyId . '":' . $recordId . '%');
                    });
            })
                ->latest()
                ->first();
        }

        if ($creationActivity && $creationActivity->causer) {
            return [
                'user' => [
                    'id' => $creationActivity->causer->id,
                    'name' => $creationActivity->causer->name ?? $creationActivity->causer->email,
                    'email' => $creationActivity->causer->email,
                    'role' => optional($creationActivity->causer->roles->first())->name,
                    'avatar' => asset($creationActivity->causer->profile_picture) ?? 'https://stock.adobe.com/search?k=default+user&asset_id=1677528100'
                ],
            ];
        }

        return [
            'user' => [
                'name' => 'System / Unknown',
                'email' => 'N/A',
                'avatar' => 'https://stock.adobe.com/search?k=default+user&asset_id=1677528100'
            ],
            'created_at' => 'Unknown',
            'message' => 'No creation activity found'
        ];
    }
}
