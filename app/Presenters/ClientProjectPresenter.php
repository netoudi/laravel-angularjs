<?php

namespace CodeProject\Presenters;

use CodeProject\Transformers\ClientProjectTransformer;
use Prettus\Repository\Presenter\FractalPresenter;

class ClientProjectPresenter extends FractalPresenter
{
    public function getTransformer()
    {
        return new ClientProjectTransformer();
    }
}
