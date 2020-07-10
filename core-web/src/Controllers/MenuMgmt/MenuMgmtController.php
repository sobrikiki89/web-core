<?php
namespace App\Http\Controllers\MenuMgmt;

use App\Http\Controllers\Controller;
use App\Services\MenuMgmt\MenuMgmtService;
use App\Services\UserMgmt\RoleMgmtService;

class MenuMgmtController extends Controller
{
    
    private MenuMgmtService $menuMgmtService;
    
    public function __construct(MenuMgmtService $menuMgmtService, RoleMgmtService $roleMgmtService)
    {
        $this->setMenuMgmtService($menuMgmtService);
        $this->roleMgmtService = $roleMgmtService;
    }
    
    public function index()
    {
        return view('secured.module.menuMgmt.list');
    }    
    
    public function gridList(){
        return response()->json($this->menuMgmtService->gridList());
    }
    
    public function new(MenuMgmtRequest $request){
        
        $selectItemFunction = $this->roleMgmtService->getSelectItemFunction();
        $selectItemMenuItemParent = $this->menuMgmtService->selectItemParent();
        
        return view('secured.module.menuMgmt.new', compact(['selectItemFunction', 'selectItemMenuItemParent']));
    }
    
    public function create(MenuMgmtRequest $request){
        
        $menuItem = $this->menuMgmtService->create($request);
        
        $selectItemFunction = $this->roleMgmtService->getSelectItemFunction();
        $selectItemMenuItemParent = $this->menuMgmtService->selectItemParent();
        
        return view('secured.module.menuMgmt.edit', compact(['menuItem', 'selectItemFunction', 'selectItemMenuItemParent']));
    }
    
    public function read($id, MenuMgmtRequest $request){
        
        $menuItem = $this->menuMgmtService->read($id);
        
        $selectItemFunction = $this->roleMgmtService->getSelectItemFunction();
        $selectItemMenuItemParent = $this->menuMgmtService->selectItemParent();
        
        return view('secured.module.menuMgmt.edit', compact(['menuItem', 'selectItemFunction', 'selectItemMenuItemParent']));
    }
    
    public function update(MenuMgmtRequest $request){
        
        $menuItem = $this->menuMgmtService->update($request);
        
        $selectItemFunction = $this->roleMgmtService->getSelectItemFunction();
        $selectItemMenuItemParent = $this->menuMgmtService->selectItemParent();
        
        return view('secured.module.menuMgmt.edit', compact(['menuItem', 'selectItemFunction', 'selectItemMenuItemParent']));
    }

    /**
     * @return mixed
     */
    public function getMenuMgmtService()
    {
        return $this->menuMgmtService;
    }

    /**
     * @param mixed $menuMgmtService
     */
    public function setMenuMgmtService($menuMgmtService)
    {
        $this->menuMgmtService = $menuMgmtService;
    }
}

