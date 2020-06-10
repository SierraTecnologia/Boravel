<?php
namespace App\Repositories\Negocios;

use App\Repositories\CmsRepository as BaseRepository;
use App\Models\Negocios\Menu;
use Cache;
use Illuminate\Support\Facades\Schema;

class MenuRepository extends BaseRepository
{
	public $model;

	public $table;

	public function __construct(Menu $model)
	{
		$this->model = $model;
		$this->table = config('cms.db-prefix').'menus';
	}

	/**
	 * Stores Menu into database.
	 *
	 * @param array $payload
	 *
	 * @return Menu
	 */
	public function store($payload)
	{
		$payload['name'] = htmlentities($payload['name']);

		return $this->model->create($payload);
	}

	/**
	 * Updates Menu into database.
	 *
	 * @param Menu  $menu
	 * @param array $payload
	 *
	 * @return Menu
	 */
	public function update($menu, $payload)
	{
		$payload['name'] = htmlentities($payload['name']);

		return $menu->update($payload);
	}

	/**
	 * Set the order
	 *
	 * @param Menu  $menu
	 * @param array $payload
	 *
	 * @return Menu
	 */
	public function setOrder($menu, $payload)
	{
		return $menu->update($payload);
	}
	
	public static function getMenuBySLUG($menuId)
	{
		return Menu::where('slug', $menuId);
	}
}
	
	/**
	 * Antigo
	 *
	 * @param [type] $menuId
	 * @return void
	 */
	
// 	public function model()
// 	{
// 		return Menu::class;
// 	}

// 	/**
// 	 * 递归菜单数据
// 	 * @author 晚黎
// 	 * @date   2016-08-09
// 	 * @param  [type]     $menus [description]
// 	 * @param  integer    $pid   [description]
// 	 * @return [type]            [description]
// 	 */
// 	public function sortMenu($menus,$pid=0)
// 	{
// 		$arr = [];
// 		if (empty($menus)) {
// 			return '';
// 		}

// 		foreach ($menus as $key => $v) {
// 			if ($v['parent_id'] == $pid) {
// 				$arr[$key] = $v;
// 				$arr[$key]['child'] = self::sortMenu($menus,$v['id']);
// 			}
// 		}
// 		return $arr;
// 	}

// 	/**
// 	 * 排序子菜单并缓存
// 	 * @author 晚黎
// 	 * @date   2016-08-09
// 	 * @param  string     $value [description]
// 	 * @return [type]            [description]
// 	 */
// 	public function sortMenuSetCache()
// 	{
// 		$menus = $this->model->orderBy('sort','desc')->get()->toArray();
// 		if ($menus) {
// 			$menuList = $this->sortMenu($menus);
// 			foreach ($menuList as $key => &$v) {
// 				if ($v['child']) {
// 					$sort = array_column($v['child'], 'sort');
// 					array_multisort($sort,SORT_DESC,$v['child']);
// 				}
// 			}
// 			// 缓存菜单数据
// 			Cache::forever(config('admin.globals.cache.menuList'),$menuList);
// 			return $menuList;
			
// 		}
// 		return '';
// 	}
// 	/**
// 	 * [getMenuList description]
// 	 * @author 晚黎
// 	 * @date   2016-08-10
// 	 * @return [type]     [description]
// 	 */
// 	public function getMenuList()
// 	{
// 		// 判断数据是否缓存
// 		if (Cache::has(config('admin.globals.cache.menuList'))) {
// 			return Cache::get(config('admin.globals.cache.menuList'));
// 		}
// 		return $this->sortMenuSetCache();
// 	}

// 	public function editMenu($id)
// 	{
// 		$menu = $this->model->find($id)->toArray();
// 		if ($menu) {
// 			$menu['update'] = url('admin/menu/'.$id);
//     		$menu['msg'] = '加载成功';
//     		$menu['status'] = true;
// 			return $menu;
// 		}
// 		return ['status' => false,'msg' => '加载失败'];
// 	}
// 	/**
// 	 * 修改菜单
// 	 * @author 晚黎
// 	 * @date   2016-08-19
// 	 * @param  [type]     $request [description]
// 	 * @return [type]              [description]
// 	 */
// 	public function updateMenu($request)
//     {
//         $menu = $this->model->find($request->id);
// 		if ($menu) {
			
// 			$isUpdate = $menu->update($request->all());
// 			if ($isUpdate) {
// 				$this->sortMenuSetCache();
// 				flash('修改菜单成功', 'success');
// 				return true;
// 			}
// 			flash('修改菜单失败', 'error');
// 			return false;
// 		}
// 		abort(404,'菜单数据找不到');
//     }
//     /**
//      * 删除菜单
//      * @author 晚黎
//      * @date   2016-08-22T07:25:20+0800
//      * @param  [type]                   $id [description]
//      * @return [type]                       [description]
//      */
//     public function destroyMenu($id){
//     	$isDelete = $this->model->destroy($id);
//     	if ($isDelete) {
//     		// 更新缓存数据
//     		$this->sortMenuSetCache();
//     		flash('删除菜单成功', 'success');
// 			return true;
//     	}
//     	flash('删除菜单失败', 'error');
// 		return false;
//     }
    // public $model;

    // public $table;

    // public function __construct(Menu $model)
    // {
    //     $this->model = $model;
    //     $this->table = config('cms.db-prefix').'menus';
    // }

    // /**
    //  * Stores Menu into database.
    //  *
    //  * @param array $payload
    //  *
    //  * @return Menu
    //  */
    // public function store($payload)
    // {
    //     $payload['name'] = htmlentities($payload['name']);

    //     return $this->model->create($payload);
    // }

    // /**
    //  * Updates Menu into database.
    //  *
    //  * @param Menu  $menu
    //  * @param array $payload
    //  *
    //  * @return Menu
    //  */
    // public function update($menu, $payload)
    // {
    //     $payload['name'] = htmlentities($payload['name']);

    //     return $menu->update($payload);
    // }

    // /**
    //  * Set the order
    //  *
    //  * @param Menu  $menu
    //  * @param array $payload
    //  *
    //  * @return Menu
    //  */
    // public function setOrder($menu, $payload)
    // {
    //     return $menu->update($payload);
    // }
// }