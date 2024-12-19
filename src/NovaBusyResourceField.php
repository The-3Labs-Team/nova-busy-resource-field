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
     */
    public function resolve($resource, ?string $attribute = null): void
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
