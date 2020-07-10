<?php
namespace App\Repositories\MenuMgmt;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use App\Domain\MenuMgmt\Model\MenuItem;

class MenuRepository
{

    protected $menu;

    public function __construct(MenuItem $menu)
    {
        $this->menu = $menu;
    }
    
    public function grid(){
        
        $listMenuItem = DB::table('menu_item as a')
                            ->leftJoin('menu_item as b', 'b.id', '=', 'a.parent_id')
                            ->orderBy('a.sort_order')
                            ->get([
                                'a.id',
                                'a.name',
                                'a.description',
                                'b.name as parent_name',
                                'a.parent_flag',
                                'a.sort_order',
                            ]);
        
        return $listMenuItem;
    }

    public function create($attributes)
    {
        
        if(isset($attributes['function_code']) && !$attributes['function_code'] != 'Select...'){
            DB::table('menu_item')->insert([
                'name' => $attributes['name'],
                'description' => $attributes['description'],
                'parent_flag' => (isset($attributes['parent_flag']) ? $attributes['parent_flag'] : false) ,
                'sort_order' => $attributes['sort_order'],
                'function_code' => ( (isset($attributes['function_code']) && $attributes['function_code'] != 'Select...') ? $attributes['function_code'] : null) ,
                'parent_id' => ( (isset($attributes['parent_id']) && $attributes['parent_id'] != 'Select...') ? $attributes['parent_id'] : null) ,
            ]);
        }else{
            DB::table('menu_item')->insert([
                'name' => $attributes['name'],
                'description' => $attributes['description'],
                'parent_flag' => (isset($attributes['parent_flag']) ? $attributes['parent_flag'] : false) ,
                'sort_order' => $attributes['sort_order'],
                'parent_id' => ((isset($attributes['parent_id']) && $attributes['parent_id'] != 'Select...') ? $attributes['parent_id'] : null) ,
            ]);            
        }
        
    }
    
    public function update($attributes)
    {
        if(isset($attributes['function_code']) && $attributes['function_code'] != 'Select...' ){
            DB::table('menu_item')
            ->where('id' , $attributes['id'])
            ->update([
                'name' => $attributes['name'],
                'description' => $attributes['description'],
                'parent_flag' => (isset($attributes['parent_flag']) ? $attributes['parent_flag'] : false) ,
                'sort_order' => $attributes['sort_order'],
                'function_code' => (isset($attributes['function_code']) ? $attributes['function_code'] : null) ,
                'parent_id' => ((isset($attributes['parent_id']) && $attributes['parent_id'] != 'Select...') ? $attributes['parent_id'] : null) ,
            ]);
        }else{
            DB::table('menu_item')
            ->where('id', $attributes['id'])
            ->update([
                'name' => $attributes['name'],
                'description' => $attributes['description'],
                'parent_flag' => (isset($attributes['parent_flag']) ? $attributes['parent_flag'] : false) ,
                'sort_order' => $attributes['sort_order'],
                'parent_id' => ((isset($attributes['parent_id']) && $attributes['parent_id'] != 'Select...') ? $attributes['parent_id'] : null) ,
            ]);
        }
        
    }

    public function all()
    {
        return $this->menu->all();
    }

    public function parentList()
    {
        
        $listMenuParent = DB::table('menu_item')
                            ->leftJoin('app_function', 'menu_item.function_code', '=', 'app_function.code')
                            ->leftJoin('role_function', 'role_function.function_code', '=', 'app_function.code')
                            ->leftJoin('user_role', 'user_role.role_id', '=', 'role_function.role_id')
                            ->where('parent_flag', true)
                            ->where('parent_id', null)
                            ->where(function ($query){
                                $query->where(
                                    function ($query1) {
                                        $query1->where('menu_item.function_code', '!=', null)
                                        ->where('user_role.user_id', '=', Auth::user()->id);
                                    })
                                    ->orWhere('menu_item.function_code', null);
                            })
                            /* ->orWhere(
                                [
                                    ['menu_item.function_code', '!=', null],
                                    ['user_role.user_id', '=', Auth::user()->id]
                                ]
                                ) */
                            ->distinct()
                            ->orderBy('sort_order', 'asc')
                            ->get(
                                    
                                    array(
                                        'menu_item.id',
                                        'menu_item.name',
                                        'menu_item.function_code',
                                        'app_function.path',
                                        'menu_item.sort_order'
                                    )
                                    
                                );
        
        return $listMenuParent;
    }
    
    public function childList($parentId){
        
        $listMenuChild = DB::table('menu_item')
                        ->leftJoin('app_function', 'menu_item.function_code', '=', 'app_function.code')
                        ->leftJoin('role_function', 'role_function.function_code', '=', 'app_function.code')
                        ->leftJoin('user_role', 'user_role.role_id', '=', 'role_function.role_id')
                        ->where('parent_id', $parentId)
                        ->where(function ($query){
                            $query->where(
                                function ($query1) {
                                    $query1->where('menu_item.function_code', '!=', null)
                                    ->where('user_role.user_id', '=', Auth::user()->id);
                                })
                                ->orWhere('menu_item.function_code', null);
                        })
                       /*  ->orWhere(
                            [
                                ['menu_item.function_code', '!=', null],
                                ['user_role.user_id', '=', Auth::user()->id]
                            ]
                            ) */
                        ->distinct()
                        ->orderBy('sort_order', 'asc')
                        ->get(                            
                                array(
                                    'menu_item.id',
                                    'menu_item.name',
                                    'menu_item.function_code',
                                    'app_function.path',
                                    'menu_item.parent_id',
                                    'menu_item.sort_order'
                                )                            
                            );
        
        return $listMenuChild;
        
    }

    public function find($id)
    {
        return DB::table('menu_item')->where('id', '=', $id)->first();
    }
    
    public function getMenuItemByName($name){
        return DB::table('menu_item')->where('name', '=', $name)->first();
    }

    public function delete($id)
    {
        return $this->menu->find($id)->delete();
    }
    
    public function selectItemParent(){
        
        return $listItem = DB::table('menu_item')
                                    ->where('parent_flag', TRUE)
                                    ->whereNull('function_code')
                                    ->pluck('name', 'id');
    }
}