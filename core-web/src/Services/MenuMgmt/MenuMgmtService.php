<?php

namespace App\Services\MenuMgmt;

use Illuminate\Support\Facades\URL;
use App\Repositories\MenuMgmt\MenuRepository;

class MenuMgmtService
{
    public function __construct(MenuRepository $menuRepository)
    {
        $this->menuRepository = $menuRepository ;
    }
    
    public function index()
    {
        return $this->menuRepository->all();
    }
    
    public function gridList()
    {
        $menuList = $this->menuRepository->grid();
        $arrayJson = $menuList->toArray();
        
        $metaMenu = array(
            "page" => 1,
            "pages" => 1,
            "perpage" => 10,
            "total" => count($menuList),
            "sort" => "asc",
            "field" => "status");
        
        
        return array("meta" => $metaMenu, "data" => $arrayJson);
    }
    
    public function create($request){
        
        $attributes = $request->all();
        $this->menuRepository->create($attributes);
        
        return $this->menuRepository->getMenuItemByName($attributes['name']);
    }
    
    public function read($id){
        return $this->menuRepository->find($id);
    }
    
    public function update($request){
        
        $attributes = $request->all();
        $this->menuRepository->update($attributes);
        
        return $this->menuRepository->getMenuItemByName($attributes['name']);
    }
    
    public function selectItemParent(){
        
        return $this->menuRepository->selectItemParent();
    }
    
    
    /* 
     * Asas menu yang menggunakan template bootstrap
     * 
     
    <ul class="navbar-nav mr-auto">
      <li class="nav-item active">
        <a class="nav-link" href="#">Home <span class="sr-only">(current)</span></a>
      </li>
      <li class="nav-item">
        <a class="nav-link" href="#">Link</a>
      </li>
      <li class="nav-item dropdown">
        <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
          Dropdown
        </a>
        <div class="dropdown-menu" aria-labelledby="navbarDropdown">
          <a class="dropdown-item" href="#">Action</a>
          <a class="dropdown-item" href="#">Another action</a>
          <div class="dropdown-divider"></div>
          <a class="dropdown-item" href="#">Something else here</a>
        </div>
      </li>
      <li class="nav-item">
        <a class="nav-link disabled" href="#">Disabled</a>
      </li>
    </ul>
     
     */
    
    public function renderMenu(){
        $listMenu = $this->menuRepository->parentList();
        
        $menuHtml = '';
        
        $activeMenu = explode('/', str_replace(URL::to('/'), '', url()->current()) . '/');
        
        $menuHtml = $menuHtml . '<ul class="navbar-nav mr-auto">';
        
        foreach ($listMenu as $menu){
            $flagMenuActive = '';          
            
            
            if( (
                    !empty($activeMenu[1]) && $activeMenu[1]==(str_replace('/', '', $menu->path))
                    ) || 
                (
                    empty($activeMenu[1]) && $menu->path == '/'
                    )
                ){
                    $flagMenuActive = 'active';
            }
            
            if(!empty($menu->function_code)){
                //have link to redirect page
                
              
                $menuHtml = $menuHtml . '<li class="nav-item '.$flagMenuActive.'">';
                
                $menuHtml = $menuHtml . '<a class="nav-link" href="'. URL::to('/') . $menu->path.'"> 
                                            ' .$menu->name. ' 
                                        </a>';
                
                $menuHtml = $menuHtml . '</li>';
                
            }else{
                
                $subMenuHtml = $this->subMenu($menu->id, true);
                
                if(!empty($subMenuHtml)){
                    $menuHtml = $menuHtml . '<li class="nav-item dropdown">';
                    
                    $menuHtml = $menuHtml . '<a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                                ' .$menu->name. ' 
                                            </a>';
                    
                    $menuHtml = $menuHtml . '<div class="dropdown-menu" aria-labelledby="navbarDropdown">';
                    
                    $menuHtml = $menuHtml . $subMenuHtml;
                    
                    $menuHtml = $menuHtml . '</div>';
                    
                    $menuHtml = $menuHtml . '</li>';
                }                
               
            }
        }
        
        $menuHtml = $menuHtml . '</ul>';
        
        return $menuHtml;
    }
    
    public function subMenu($parentId, $firstLevel){
        
        $menuAvailable = false;
        $listSubMenu = $this->menuRepository->childList($parentId);
        
        $subMenuHtml = '';
        
        $activeMenu = explode('/', str_replace(URL::to('/'), '', url()->current()) . '/');
        
        if(!empty($listSubMenu)){
            
            foreach ($listSubMenu as $subMenu){
                    
                $flagMenuActive = '';
                if( (
                    !empty($activeMenu[1]) && $activeMenu[1]==(str_replace('/', '', $subMenu->path))
                    ) ||
                    (
                        empty($activeMenu[1]) && $subMenu->path == '/'
                        )
                    ){
                        $flagMenuActive = 'active';
                }
                
                
                
                if(!empty($subMenu->function_code)){
                    
                    $subMenuHtml = $subMenuHtml . '<a class="dropdown-item '.$flagMenuActive.'" href="'. URL::to('/') . $subMenu->path.'">' .$subMenu->name. '</a>';
                    
                    $menuAvailable = true;
                }else{
                    
                    $nestedMenuHtml = $this->subMenu($subMenu->id, false);
                    
                    if(!empty($nestedMenuHtml)){
                        
                        $menuAvailable = true;
                        
                        if(!$firstLevel){
                            $subMenuHtml = $subMenuHtml . '<li class="nav-item dropdown">';
                        }                        
                        
                        $subMenuHtml = $subMenuHtml . '<a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                                        ' .$subMenu->name. '
                                                    </a>';
                        
                        $subMenuHtml = $subMenuHtml . '<div class="dropdown-menu '.$flagMenuActive.'" aria-labelledby="navbarDropdown">';
                        
                        $subMenuHtml = $subMenuHtml . $nestedMenuHtml;
                        
                        $subMenuHtml = $subMenuHtml . '</div>';
                        
                        if(!$firstLevel){
                            $subMenuHtml = $subMenuHtml . '</li>';
                        }
                        
                    }
                    
                }
            }                    
        }
        
        if($menuAvailable)
            return $subMenuHtml;
        else
            return null;
        
    }
    
}