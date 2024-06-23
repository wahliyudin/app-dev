<?php

namespace App\Domain\Workflows\Contracts;

use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;

interface ModelThatHaveWorkflow
{
    /**
     * @return HasOne
     */
    public function workflow(): HasOne;

    /**
     * @return HasMany
     */
    public function workflows(): HasMany;
}
