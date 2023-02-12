<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreFormRequest;
use App\Http\Requests\UpdateFormRequest;
use App\Http\Resources\FormResource;
use App\Models\Form;
use Illuminate\Http\Request;

class FormController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return $this->responseSuccess([
            'forms' => FormResource::collection(Form::get())
        ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreFormRequest $request)
    {
        $data = $request->all();
        
        //validate form fields
        $validationErrors = ['fields' => [[]]];
        $hasErrors = false;
        foreach ($data['fields'] as $key => $field) {
            $fieldErrors = ['title' => '', 'type' => ''];
            if (empty($field['title'])) {
                $hasErrors = true;
                $fieldErrors['title'] = 'The title field is required.';
            }
            if (empty($field['type'])) {
                $hasErrors = true;
                $fieldErrors['type'] = 'The type field is required.';
            }
            $validationErrors['fields'][0][] = $fieldErrors;
        }
        
        if ($hasErrors) {
            return $this->responseValidationError($validationErrors);
        }
        
        $form = Form::create($data);
        $form->fields()->createMany($data['fields']);

        return $this->responseSuccess([
            'form' => FormResource::make($form)
        ]);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $form = Form::find($id);
        if (!$form) {
            return $this->responseNotFound();
        }

        return $this->responseSuccess([
            'form' => FormResource::make($form)
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateFormRequest $request, $id)
    {
        $form = Form::find($id);
        if (!$form) {
            return $this->responseNotFound();
        }

        $data = $request->all();
        $form->update($data);

        return $this->responseSuccess([
            'form' => FormResource::make($form)
        ]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $form = Form::find($id);
        if (!$form) {
            return $this->responseNotFound();
        }
        $form->delete();

        return $this->responseSuccess();
    }
}
