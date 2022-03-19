
<div class="sidebar-menu">
  <ul class="menu-items">

    @foreach(Session('menus') as $menu )

    @if($menu->route != "NULL")
      @if($menu->is_active == 1)
      <li class="@yield($menu->slug)">
        <a href="{{ route($menu->route) }}">
          <span class="title">{{$menu->title}}</span>
        </a>
        <span class="icon-thumbnail"> <?php echo $menu->menu_icon; ?> </span>
      </li>
      @endif
    @else
    <li class="@yield($menu->slug)">
      @if($menu->is_active == 1)
      <a href="javascript:;"><span class="title"> {{$menu->title}} </span>
        <span class=" arrow @yield($menu->slug)"></span></a>
      <span class="icon-thumbnail"> <?php echo $menu->menu_icon; ?> </span>

      @php $sub_menus = $menu->sub_menu; @endphp
      <ul class="sub-menu">
        @foreach($sub_menus as $sub_menu)
        @if($sub_menu->is_active == 1)
        <li class="@yield($sub_menu->slug)">
          <a href="{{ route($sub_menu->route) }}"> {{$sub_menu->title}}  </a>
          <span class="icon-thumbnail"> <?php echo $sub_menu->menu_icon; ?> </span>
        </li>
        @endif
        @endforeach
      </ul>
      @endif
    </li>
    @endif

    @endforeach

  </ul>
  <div class="clearfix"></div>
</div>