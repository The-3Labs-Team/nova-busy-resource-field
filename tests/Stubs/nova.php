<?php

namespace Laravel\Nova\Events {
    if (! class_exists(ServingNova::class)) {
        class ServingNova
        {
            public function __construct(
                public $app = null,
                public $request = null
            ) {
            }
        }
    }
}

namespace Laravel\Nova {
    if (! class_exists(Nova::class)) {
        class Nova
        {
            public static array $servingCallbacks = [];
            public static array $scripts = [];
            public static array $styles = [];

            public static function serving(callable $callback): void
            {
                static::$servingCallbacks[] = $callback;
            }

            public static function script(string $name, string $path): void
            {
                static::$scripts[$name] = $path;
            }

            public static function style(string $name, string $path): void
            {
                static::$styles[$name] = $path;
            }
        }
    }
}

namespace Laravel\Nova\Fields {
    if (! class_exists(Field::class)) {
        class Field
        {
            public array $meta = [];

            public function __construct(
                public $name = null,
                public ?string $attribute = null,
                public $resolveCallback = null
            ) {
            }

            public static function make(...$arguments): static
            {
                return new static(...$arguments);
            }

            public function withMeta(array $meta): static
            {
                $this->meta = array_merge($this->meta, $meta);

                return $this;
            }

            public function resolve($resource, ?string $attribute = null): void
            {
            }
        }
    }
}
