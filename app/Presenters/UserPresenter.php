<?php

namespace CodeProject\Presenters;

use CodeProject\Transformers\UserTransformer;
use Prettus\Repository\Presenter\FractalPresenter;

class UserPresenter extends FractalPresenter
{
    public function getTransformer()
    {
        return new UserTransformer();
    }
}
