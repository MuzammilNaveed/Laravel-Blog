<ol class="dd-list">
    @foreach($childs as $child)
    <li class="dd-item" data-id="{{$child->id}}" data-position="{{$child->id}}">
        <div class="menu-item-actions">
            <a href="{{url('edit-menu-item')}}/{{$child->id}}/{{$id}}"> <i class="fas fa-pencil-alt ml-1"></i> </a>
            <i class="fas fa-times ml-2" onclick="del({{$item->id}})"></i>
        </div>
        <div class="dd-handle">{{$child->name}} </div>
        @if(count($child->childs))
            @include('admin.menu.manage_child',['childs' => $child->childs])
        @endif
    </li>
    @endforeach
</ol>