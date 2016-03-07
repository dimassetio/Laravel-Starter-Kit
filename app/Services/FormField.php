<?php

namespace App\Services;
use Form;
use Illuminate\Support\Collection;
use Illuminate\Support\MessageBag;
use Lang;
use Session;

/**
* FormField Class (Site FormField Service)
*/
class FormField
{

    protected $errorBag;
    protected $options;
    protected $fieldParams;

    public function __construct()
    {
        $this->errorBag = Session::get('errors', new MessageBag);;
    }

    public function text($name, $options = [])
    {
        $hasError = $this->errorBag->has($name) ? 'has-error' : '';
        $value = isset($options['value']) ? $options['value'] : null;
        $type = isset($options['type']) ? $options['type'] : 'text';

        $fieldParams = ['class'=>'form-control'];
        if (isset($options['class'])) { $fieldParams['class'] .= ' ' . $options['class']; }

        $htmlForm = '';
        $htmlForm .= '<div class="form-group ' . $hasError . '">';
        if (isset($options['label']) && $options['label'] != false) {
            $label = isset($options['label']) ? $options['label'] : str_split_ucwords($name);
            $htmlForm .= Form::label($name, $label, ['class'=>'control-label']) . '&nbsp;';
        }

        if (isset($options['addon'])) { $htmlForm .= '<div class="input-group">'; }
        if (isset($options['addon']['before'])) {
            $htmlForm .= '<span class="input-group-addon">' . $options['addon']['before'] . '</span>';
        }
        if (isset($options['readonly']) && $options['readonly'] == true) { $fieldParams += ['readonly']; }
        if (isset($options['disabled']) && $options['disabled'] == true) { $fieldParams += ['disabled']; }
        if (isset($options['required']) && $options['required'] == true) { $fieldParams += ['required']; }
        if (isset($options['min'])) { $fieldParams += ['min' => $options['min']]; }
        if (isset($options['placeholder'])) { $fieldParams += ['placeholder' => $options['placeholder']]; }

        $htmlForm .= Form::input($type, $name, $value, $fieldParams);

        if (isset($options['addon']['after'])) {
            $htmlForm .= '<span class="input-group-addon">' . $options['addon']['after'] . '</span>';
        }
        if (isset($options['addon'])) { $htmlForm .= '</div>'; }
        if (isset($options['info'])) {
            $htmlForm .= '<p class="text-' . $options['info']['class'] . ' small">' . $options['info']['text'] . '</p>';
        }
        $htmlForm .= $this->errorBag->first($name, '<span class="form-error">:message</span>');

        $htmlForm .= '</div>';

        return $htmlForm;
    }

    public function textarea($name, $options = [])
    {
        $hasError = $this->errorBag->has($name) ? 'has-error' : '';
        $label = isset($options['label']) ? $options['label'] : str_split_ucwords($name);
        $rows = isset($options['rows']) ? $options['rows'] : 5;
        $value = isset($options['value']) ? $options['value'] : null;

        $fieldParams = ['class'=>'form-control','rows' => $rows];

        if (isset($options['readonly']) && $options['readonly'] == true) { $fieldParams += ['readonly']; }
        if (isset($options['disabled']) && $options['disabled'] == true) { $fieldParams += ['disabled']; }
        if (isset($options['required']) && $options['required'] == true) { $fieldParams += ['required']; }
        if (isset($options['placeholder'])) { $fieldParams += ['placeholder' => $options['placeholder']]; }

        $htmlForm = '<div class="form-group ' . $hasError . '">';
        $htmlForm .= Form::label($name, $label, ['class'=>'control-label']);
        $htmlForm .= Form::textarea($name, $value, $fieldParams);
        $htmlForm .= $this->errorBag->first($name, '<span class="form-error">:message</span>');
        $htmlForm .= '</div>';

        return $htmlForm;
    }

    public function select($name, $selectOptions, $options = [])
    {
        $hasError = $this->errorBag->has($name) ? 'has-error' : '';
        $htmlForm = '';
        $value = isset($options['value']) ? $options['value'] : null;

        $fieldParams = ['class'=>'form-control'];
        if (isset($options['class'])) { $fieldParams['class'] .= ' ' . $options['class']; }

        if (isset($options['readonly']) && $options['readonly'] == true) { $fieldParams += ['readonly']; }
        if (isset($options['disabled']) && $options['disabled'] == true) { $fieldParams += ['disabled']; }
        if (isset($options['required']) && $options['required'] == true) { $fieldParams += ['required']; }
        if (isset($options['multiple']) && $options['multiple'] == true) { $fieldParams += ['multiple', 'name' => $name . '[]']; }
        if (isset($options['placeholder'])) { $fieldParams += ['placeholder' => $options['placeholder']]; }

        $htmlForm .= '<div class="form-group ' . $hasError . '">';
        if (isset($options['label']) && $options['label'] != false) {
            $label = isset($options['label']) ? $options['label'] : str_split_ucwords($name);
            $htmlForm .= Form::label($name, $label, ['class'=>'control-label']);
        }

        $htmlForm .= Form::select($name, $selectOptions, $value, $fieldParams);
        $htmlForm .= $this->errorBag->first($name, '<span class="form-error">:message</span>');

        $htmlForm .= '</div>';

        return $htmlForm;
    }

    public function multiSelect($name, $selectOptions, $options = [])
    {
        $options['multiple'] = true;

        return $this->select($name, $selectOptions, $options);
    }

    public function email($name, $options = [])
    {
        $option['type'] = 'email';
        return $this->text($name, $options);
    }

    public function password($name, $options = [])
    {
        $hasError = $this->errorBag->has($name) ? 'has-error' : '';
        $label = isset($options['label']) ? $options['label'] : str_split_ucwords($name);

        $htmlForm = '<div class="form-group ' . $hasError . '">';
        $htmlForm .= Form::label($name, $label, ['class'=>'control-label']);
        $htmlForm .= Form::password($name, ['class'=>'form-control']);
        if (isset($options['info'])) {
            $htmlForm .= '<p class="text-' . $options['info']['class'] . ' small">' . $options['info']['text'] . '</p>';
        }
        $htmlForm .= $this->errorBag->first($name, '<span class="form-error">:message</span>');
        $htmlForm .= '</div>';

        return $htmlForm;
    }

    public function radios($name, array $radioOptions, $options = [])
    {
        $hasError = $this->errorBag->has($name) ? 'has-error' : '';

        $htmlForm = '';

        $htmlForm .= '<div class="form-group ' . $hasError . '">';
        if (isset($options['label']) && $options['label'] != false) {
            $label = isset($options['label']) ? $options['label'] : str_split_ucwords($name);
            $htmlForm .= Form::label($name, $label, ['class'=>'control-label']);
        }

        $htmlForm .= '<div class="radio">';

        foreach ($radioOptions as $key => $option) {

            $value = null;

            if (isset($options['value']) && $options['value'] == $key) {
                $value = true;
            }

            $htmlForm .= '<label for="' . $name . '_' . $key . '" style="margin-right: 14px;">';
            $htmlForm .= Form::radio($name, $key, $value, ['id' => $name . '_' . $key]);
            $htmlForm .= $option;
            $htmlForm .= '</label>';
        }
        $htmlForm .= '</div>';
        $htmlForm .= $this->errorBag->first($name, '<span class="form-error">:message</span>');

        $htmlForm .= '</div>';

        return $htmlForm;
    }

    public function checkboxes($name, array $checkboxOptions, $options = [])
    {

        if (isset($options['label'])) {
            $label = $options['label'] == false ? '' : $options['label'];
        } else {
            $label = str_split_ucwords($name);
        }

        $hasError = $this->errorBag->has($name) ? 'has-error' : '';
        $label = isset($options['label']) ? $options['label'] : str_split_ucwords($name);
        $value = isset($options['value']) ? $options['value'] : new Collection;

        $htmlForm = '<div class="form-group ' . $hasError . '">';
        $htmlForm .= Form::label($name, $label, ['class'=>'control-label']);
        $htmlForm .= '<div class="checkbox">';

        foreach ($checkboxOptions as $key => $option) {
            $htmlForm .= '<label for="' . $name . '_' . $key . '" style="margin-right: 20px;">';
            $htmlForm .= Form::checkbox($name . '[]', $key, $value->contains($key), ['id' => $name . '_' . $key]);
            $htmlForm .= $option;
            $htmlForm .= '</label>';
        }
        $htmlForm .= '</div>';
        $htmlForm .= $this->errorBag->first($name, '<span class="form-error">:message</span>');
        $htmlForm .= '</div>';

        return $htmlForm;
    }

    public function textDisplay($name, $value, $options = [])
    {
        $label = isset($options['label']) ? $options['label'] : str_split_ucwords($name);

        $htmlForm = '<div class="form-group">';
        $htmlForm .= Form::label($name, $label, ['class'=>'control-label']);
        $htmlForm .= '<div class="form-control" readonly>' . $value . '</div>';
        $htmlForm .= '</div>';

        return $htmlForm;
    }

    public function file($name, $options = [])
    {
        $hasError = $this->errorBag->has($name) ? 'has-error' : '';
        $label = isset($options['label']) ? $options['label'] : str_split_ucwords($name);

        $htmlForm = '<div class="form-group ' . $hasError . '">';
        $htmlForm .= Form::label($name, $label, ['class'=>'control-label']) . '&nbsp;';
        $htmlForm .= Form::file($name, ['class'=>'form-control']);
        if (isset($options['info'])) {
            $htmlForm .= '<p class="text-' . $options['info']['class'] . ' small">' . $options['info']['text'] . '</p>';
        }
        $htmlForm .= $this->errorBag->first($name, '<span class="form-error">:message</span>');
        $htmlForm .= '</div>';

        return $htmlForm;
    }

    public function delete($form_params = [], $button_label = 'Delete', $button_options = [], $hiddenFields = [])
    {
        $form_params['method'] = 'delete';
        $form_params['class'] = isset($form_params['class']) ? $form_params['class'] : 'del-form';
        $form_params['style'] = isset($form_params['style']) ? $form_params['style'] : 'display:inline';

        if (! isset($button_options['class']))
            $button_options['class'] = 'pull-right';

        if (! isset($button_options['title']))
            $button_options['title'] = 'Delete this record';

        $htmlForm = Form::open($form_params);
        if (!empty($hiddenFields))
        {
            foreach ($hiddenFields as $k => $v)
            {
                $htmlForm .= Form::hidden($k, $v);
            }
        }
        $htmlForm .= Form::submit($button_label, $button_options);
        $htmlForm .= Form::close();

        return $htmlForm;
    }

    public function arrays($name, array $fieldKeys, $options = [])
    {
        $hasError = $this->errorBag->has($name) ? 'has-error' : '';
        $label = isset($options['label']) ? $options['label'] : str_split_ucwords($name);

        $htmlForm = '<div class="form-group ' . $hasError . '">';
        $htmlForm .= Form::label($name, $label, ['class'=>'control-label']);

        if (empty($contents) == false) {
            foreach ($checkboxOptions as $key => $option) {
                $htmlForm .= '<div class="row">';
                $htmlForm .= Form::text($name . '[]', $key);
                $htmlForm .= '</div>';
            }
        }

        $htmlForm .= '<div class="new-' . $name . ' row">';
        $htmlForm .= '<div class="col-md-4">';
        $htmlForm .= Form::text($fieldKeys[0], null, ['class' => 'form-control']);
        $htmlForm .= '</div>';
        $htmlForm .= '<div class="col-md-8 row">';
        $htmlForm .= Form::text($fieldKeys[1], null, ['class' => 'form-control']);
        $htmlForm .= '</div>';
        $htmlForm .= '</div>';
        $htmlForm .= '<a id="add-service" class="btn btn-info btn-xs pull-right"><i class="fa fa-plus fa-fw"></i></a>';

        $htmlForm .= $this->errorBag->first($name, '<span class="form-error">:message</span>');
        $htmlForm .= '</div>';

        return $htmlForm;
    }
}