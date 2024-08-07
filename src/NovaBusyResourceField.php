<?php

namespace The3labsTeam\NovaBusyResourceField;

use Laravel\Nova\Fields\Field;

class NovaBusyResourceField extends Field
{
    /**
     * The field's component.
     *
     * @var string
     */
    public $component = 'nova-busy-resource-field';

    /**
     * Resolve the field's value.
     *
     * @param  mixed  $resource
     * @param  string|null  $attribute
     * @return void
     */
    public function resolve($resource, $attribute = null)
    {
        parent::resolve($resource, $attribute);

        $user = auth()->user();
        $isBusy = $resource->isBusy();
        $isBusyByCurrentUser = $resource->isBusyByUser($user);

        $this->withMeta([
            'isBusy' => $isBusy,
            'isBusyByCurrentUser' => $isBusyByCurrentUser,
        ]);
    }
}
