
<ul class="submenu dropdown-menu" aria-labelledby="navbarDropdown">
    @foreach($childs as $child)
        <li class="nav-item {{count($child->childs) > 0 ? 'dropdown' : ''}}"> 
            <a class="dropdown-item" href="{{url('category')}}">
                {{$child->name}}
                <?= count($child->childs) > 0 ? '<i class="fas fa-chevron-right"></i>' : '' ?>  
            </a>    
            
            @if(count($child->childs) > 0)
                @include('website.layout.child',['childs' => $child->childs])
            @endif
            
        </li>
    @endforeach
</ul>