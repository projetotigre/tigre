<?php

class BaseController extends Controller {

    /**
     * Pagination limit
     * @var int
     */
    protected $limit;


    public function __construct()
    {
        $this->limit = Config::get('view.pagination-limit');
    }

	/**
	 * Setup the layout used by the controller.
	 *
	 * @return void
	 */
	protected function setupLayout()
	{
		if ( ! is_null($this->layout))
		{
			$this->layout = View::make($this->layout);
		}
	}

}
