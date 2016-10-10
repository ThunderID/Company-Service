<?php 

namespace App\Entities\Observers;

use Illuminate\Support\MessageBag;
use Illuminate\Support\Str;

use App\Entities\Company as Model; 

/**
 * Used in Company model
 *
 * @author cmooy
 */
class CompanyObserver 
{
	public function saving($model)
	{
		return true;
	}
}
