<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use aleia\LaravelAdminCore\Requests\StoreMenuItemRequest;
use aleia\LaravelAdminCore\Requests\UpdateMenuItemRequest;
use aleia\LaravelMenu\Models\Menu;
use aleia\LaravelMenu\Models\MenuItem;

class MenuItemController extends Controller
{
    public function __construct()
    {
        $this->middleware('can:menu list', ['only' => ['index', 'show']]);
        $this->middleware('can:menu create', ['only' => ['create', 'store']]);
        $this->middleware('can:menu edit', ['only' => ['edit', 'update']]);
        $this->middleware('can:menu delete', ['only' => ['destroy']]);
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\View\View
     */
    public function index(Menu $menu)
    {
        $items = (new MenuItem)->toTree($menu->id);

        return view('admin.menu.item.index', compact('items', 'menu'));
    }

        /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\View\View
     */
    public function create(Menu $menu)
    {
        $item_options = MenuItem::selectOptions($menu->id);
        return view('admin.menu.item.create', compact('menu', 'item_options'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  StoreMenuItemRequest  $request
     * @param  \aleia\LaravelMenu\Models\Menu $menu
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(StoreMenuItemRequest $request, Menu $menu)
    {
        $menu->menuItems()->create($request->all());

        return redirect()->route('menu.item.index', $menu->id)
                        ->with('message', 'Menu created successfully.');
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \aleia\LaravelMenu\Models\Menu $menu
     * @return \Illuminate\View\View
     */
    public function edit(Menu $menu, MenuItem $item)
    {
        $item_options = MenuItem::selectOptions($menu->id, $item->parent_id ?? $item->id);
        return view('admin.menu.item.edit', compact('menu', 'item', 'item_options'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  UpdateMenuItemRequest  $request
     * @param  \aleia\LaravelMenu\Models\Menu $menu
     * @param  \aleia\LaravelMenu\Models\MenuItem $item
     * @return \Illuminate\Http\RedirectResponse
     */
    public function update(UpdateMenuItemRequest $request, Menu $menu, MenuItem $item)
    {
        $item->update($request->all());

        return redirect()->route('menu.item.index', $menu->id)
                        ->with('message', 'Menu Item updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \aleia\LaravelMenu\Models\Menu $menu
     * @param  \aleia\LaravelMenu\Models\MenuItem $menuItem
     * @return \Illuminate\Http\RedirectResponse
     */
    public function destroy(Menu $menu, MenuItem $item)
    {
        $item->delete();

        return redirect()->route('menu.item.index', $menu->id)
                        ->with('message', __('Menu deleted successfully'));
    }
}