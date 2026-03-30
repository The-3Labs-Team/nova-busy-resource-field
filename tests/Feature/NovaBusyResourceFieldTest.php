<?php

namespace Tests\Feature;

use Illuminate\Auth\GenericUser;
use Tests\TestCase;
use The3labsTeam\NovaBusyResourceField\NovaBusyResourceField;

class NovaBusyResourceFieldTest extends TestCase
{
    public function test_it_hydrates_the_busy_flags_from_the_resource_state(): void
    {
        auth()->setUser(new GenericUser(['id' => 1]));

        $resource = new class
        {
            public function isBusy(): bool
            {
                return true;
            }

            public function isBusyByUser($user): bool
            {
                return (int) ($user?->id ?? 0) === 1;
            }
        };

        $field = NovaBusyResourceField::make('Busy');

        $field->resolve($resource, 'busy');

        $this->assertSame('nova-busy-resource-field', $field->component);
        $this->assertTrue($field->meta['isBusy']);
        $this->assertTrue($field->meta['isBusyByCurrentUser']);
    }
}
