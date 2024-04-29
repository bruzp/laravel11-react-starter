<?php

namespace App\Http\Resources\Admin;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class QuestionResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        $data = [
            'id' => $this->id,
            'questionnaire_id' => $this->questionnaire_id,
            'question' => $this->question,
            'choices' => @unserialize($this->choices) ?: [],
            'answer' => $this->answer,
            'priority' => $this->priority,
            'created_at' => $this->created_at->toDateTimeString(),
            'updated_at' => $this->updated_at->toDateTimeString(),
            'created_at_for_humans' => $this->created_at->diffForHumans(),
            'updated_at_for_humans' => $this->updated_at->diffForHumans(),
        ];

        if ($this->relationLoaded('questionnaire')) {
            $data['questionnaire'] = new QuestionnaireResource($this->questionnaire);
        }

        return $data;
    }
}
