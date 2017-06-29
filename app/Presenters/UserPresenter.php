<?php

namespace CodeProject\Presenters;

use CodeProject\Transformers\UserTransformer;
use Prettus\Repository\Presenter\FractalPresenter;

class UserPresenter extends FractalPresenter {
	public function getTransformer() {
		// TODO: Implement getTransformer() method.
		return new UserTransformer ();
	}
}