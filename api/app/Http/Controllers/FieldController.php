<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreFieldRequest;
use App\Http\Requests\UpdateFieldRequest;
use App\Http\Requests\UpdateFieldValueRequest;
use App\Http\Resources\FieldResource;
use App\Http\Resources\FormResource;
use App\Models\Field;
use App\Models\Form;
use Illuminate\Http\Request;

class FieldController extends Controller
{
    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $formId
     * @return \Illuminate\Http\Response
     */
    public function updateFieldValue(UpdateFieldValueRequest $request, $formId)
    {
        $form = Form::find($formId);
        if (!$form) {
            return $this->responseNotFound();
        }

        
        foreach ($form->fields as $field) {
            foreach ($request->fields as $newField) {
                if($field['id'] == $newField['id']) {
                    $field->fill($newField);
                    $field->save();
                }
            }
        }

        return $this->responseSuccess([
            'fields' => FieldResource::collection($form->fields)
        ]);
    }
    
    /**
     * Reset all form fields
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $formId
     * @return \Illuminate\Http\Response
     */
    public function resetFields(UpdateFieldValueRequest $request, $formId)
    {
        $form = Form::find($formId);
        if (!$form) {
            return $this->responseNotFound();
        }

        $form->fields()->update(['value' => null]);

        return $this->responseSuccess([
            'form' => FormResource::make($form)
        ]);
    }

}
