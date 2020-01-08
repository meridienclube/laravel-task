<?php

namespace MeridienClube\Meridien\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateTaskRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'sync.destinateds' => 'required',
            'sync.responsibles' => 'required',
            'type_id' => 'required'
        ];
    }

    public function messages()
    {
        return [
            'sync.destinateds.required' => 'Destinatário é obrigatório',
            'sync.responsibles.required' => 'Responsavel é obrigatório',
            'type_id.required'  => 'Escolha um tipo de tarefa antes de salvar',
        ];
    }
}
