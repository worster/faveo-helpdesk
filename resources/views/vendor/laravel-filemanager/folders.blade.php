<div class="col-sm-4 col-md-3 col-lg-2">
  <div class="thumbnail text-center" data-id="{{ $dir_name->path }}">
    <a data-id="{{ $dir_name->path }}" class="folder-icon pointer folder-item">
      <img src="{{ $dir_name->thumb }}" style='max-height:200px;'>
    </a>
  </div>
  <div class="caption text-center">
    <div class="btn-group">
      <button type="button" data-id="{{ $dir_name->path }}" class="btn btn-default btn-xs folder-item">
        {{ str_limit($dir_name->name, $limit = 10, $end = '...') }}
      </button>
      <button type="button" class="btn btn-default dropdown-toggle btn-xs" data-toggle="dropdown" aria-expanded="false">
        <span class="caret"></span>
        <span class="sr-only">Toggle Dropdown</span>
      </button>
      <ul class="dropdown-menu" role="menu">
        <li><a href="javascript:rename('{{ $dir_name->name }}')"><i class="fa fa-edit fa-fw"></i> {{ Lang::get('laravel-filemanager::lfm.menu-rename') }}</a></li>
        <li><a href="javascript:trash('{{ $dir_name->name }}')"><i class="fa fa-trash fa-fw"></i> {{ Lang::get('laravel-filemanager::lfm.menu-delete') }}</a></li>
      </ul>
    </div>

  </div>
</div>
