<?php

namespace CodeProject\Presenters;
use CodeProject\Transformers\ProjectNotePresenter;
use Prettus\Repository\Presenter\FractalPresenter;
/**
 * Class ProjectNotePresenter
 *
 * @package namespace CodeProject\Presenters;
 */
class ProjectNotePresenter extends FractalPresenter
{
	/**
	 * Transformer
	 *
	 * @return \League\Fractal\TransformerAbstract
	 */
	public function getTransformer()
	{
		return new ProjectNotePresenter();
	}
}