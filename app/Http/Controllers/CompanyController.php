<?php

namespace App\Http\Controllers;

use App\Libraries\JSend;

use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Validator;
use Illuminate\Http\Request;

use App\Entities\Company;

use League\Fractal\Manager;
use League\Fractal\Resource\Collection;

/**
 * Company  resource representation.
 *
 * @Resource("Company", uri="/companies")
 */
class CompanyController extends Controller
{
	public function __construct(Request $request)
	{
		$this->request 				= $request;
	}

	/**
	 * Show all companies
	 *
	 * @Get("/")
	 * @Versions({"v1"})
	 * @Transaction({
	 *      @Request({"search":{"_id":"string","name":"string","code":"string"},"sort":{"newest":"asc|desc"}, "take":"integer", "skip":"integer"}),
	 *      @Response(200, body={"status": "success", "data": {"data":{"_id":{"value":"1234567890", "type":"string", "max":"255"},"name":{"value":"PT THUNDERLABS INDONESIA", "type":"string", "max":"255"},"code":{"value":"TLID", "type":"string", "max":"255"}},"count":"integer"} })
	 * })
	 */
	public function index()
	{
		$result						= new Company;

		if(Input::has('search'))
		{
			$search					= Input::get('search');

			foreach ($search as $key => $value) 
			{
				switch (strtolower($key)) 
				{
					case '_id':
						$result		= $result->id($value);
						break;
					case 'name':
						$result		= $result->name($value);
						break;
					case 'code':
						$result		= $result->code($value);
						break;
					default:
						# code...
						break;
				}
			}
		}

		if(Input::has('sort'))
		{
			$sort					= Input::get('sort');

			foreach ($sort as $key => $value) 
			{
				if(!in_array($value, ['asc', 'desc']))
				{
					return response()->json( JSend::error([$key.' harus bernilai asc atau desc.'])->asArray());
				}
				switch (strtolower($key)) 
				{
					case 'newest':
						$result		= $result->orderby('created_at', $value);
						break;
					default:
						# code...
						break;
				}
			}
		}
		else
		{
			$result		= $result->orderby('created_at', 'asc');
		}

		$count						= count($result->get());

		if(Input::has('skip'))
		{
			$skip					= Input::get('skip');
			$result					= $result->skip($skip);
		}

		if(Input::has('take'))
		{
			$take					= Input::get('take');
			$result					= $result->take($take);
		}

		$result 					= $this->getStructure($result->get()->toArray());

		return response()->json( JSend::success([array_merge($result, ['count' => $count])])->asArray())
				->setCallback($this->request->input('callback'));
	}

	/**
	 * Store Company
	 *
	 * @Post("/")
	 * @Versions({"v1"})
	 * @Transaction({
	 *      @Request({"_id":"string","name":"string","code":"string"}),
	 *      @Response(200, body={"status": "success", "data": {"_id":{"value":"1234567890", "type":"string", "max":"255"},"name":{"value":"PT THUNDERLABS INDONESIA", "type":"string", "max":"255"},"code":{"value":"TLID", "type":"string", "max":"255"}}}),
	 *      @Response(200, body={"status": {"error": {"code must be unique."}}})
	 * })
	 */
	public function post()
	{
		$id 			= Input::get('_id');

		if(!is_null($id) && !empty($id))
		{
			$result		= Company::id($id)->first();
		}
		else
		{
			$result 	= new Company;
		}
		

		$result->fill(Input::only('name', 'code'));

		if($result->save())
		{
			return response()->json( JSend::success($this->getStructure([$result->toArray()])['data'][0])->asArray())
					->setCallback($this->request->input('callback'));
		}
		
		return response()->json( JSend::error($result->getError())->asArray());
	}

	/**
	 * Delete Company
	 *
	 * @Delete("/")
	 * @Versions({"v1"})
	 * @Transaction({
	 *      @Request({"_id":null}),
	 *      @Response(200, body={"status": "success", "data": {"_id":{"value":"1234567890", "type":"string", "max":"255"},"name":{"value":"PT THUNDERLABS INDONESIA", "type":"string", "max":"255"},"code":{"value":"TLID", "type":"string", "max":"255"}}}),
	 *      @Response(200, body={"status": {"error": {"code must be unique."}}})
	 * })
	 */
	public function delete()
	{
		$company 			= Company::id(Input::get('_id'))->first();
		
		$result 			= $company;

		if($company && $company->delete())
		{
			return response()->json( JSend::success($this->getStructure([$result->toArray()])['data'][0])->asArray())
					->setCallback($this->request->input('callback'));
		}

		if(!$company)
		{
			return response()->json( JSend::error(['ID tidak valid'])->asArray());
		}

		return response()->json( JSend::error($company->getError())->asArray());
	}

	/**
	 * Fractal Modifying Returned Value
	 *
	 * getStructure method used to transforming response format and included UI inside (@UInside)
	 */
	public function getStructure($draft)
	{
		$fractal 					= new Manager();
		$resource 					= new Collection($draft, function(array $company) {
										return [
												'id' 	=> [
																'value' => $company['_id'],
																'type'	=> 'string',
																'max'	=> '255',
															],
												'name' 	=> [
																'value' => $company['name'],
																'type'	=> 'string',
																'max'	=> '255',
															],
												'code' 	=> [
																'value' => $company['code'],
																'type'	=> 'string',
																'max'	=> '255',
															],
											];
										});

		// Turn that into a structured array (handy for XML views or auto-YAML converting)
		$array 						= $fractal->createData($resource)->toArray();

		return $array;
	}
}