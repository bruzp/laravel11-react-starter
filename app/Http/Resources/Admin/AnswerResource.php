<?php

namespace App\Http\Resources\Admin;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class AnswerResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        $questionnaire_data = @unserialize($this->questionnaire_data);

        foreach ($questionnaire_data as &$data) {
            $data['choices'] = @unserialize($data['choices']);
        }

        return [
            'id' => $this->id,
            'questionnaire_id' => $this->questionnaire_id,
            'user_id' => $this->user_id,
            'answers' => @unserialize($this->answers),
            'result' => $this->result,
            'questionnaire_data' => $questionnaire_data,
            'created_at' => $this->created_at->toDateTimeString(),
            'updated_at' => $this->updated_at->toDateTimeString(),
            'created_at_for_humans' => $this->created_at->diffForHumans(),
            'updated_at_for_humans' => $this->updated_at->diffForHumans(),

            // users data
            'name' => $this->name ?? '',
            'email' => $this->email ?? '',

            // questionnaire data
            'title' => $this->title ?? '',
            'description' => $this->description ?? '',
        ];
    }
}
