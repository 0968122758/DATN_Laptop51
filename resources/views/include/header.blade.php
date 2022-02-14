<header class="c-header c-header-light c-header-fixed c-header-with-subheader">
    {{-- <button class="c-header-toggler c-class-toggler d-lg-none mr-auto" type="button" data-target="#sidebar" data-class="c-sidebar-show">
        <span class="c-header-toggler-icon"></span>
    </button> --}}
    <a class="c-header-brand d-sm-none" href="#">
        <img class="c-header-brand" src="{{ url('/images/logos/logo.png') }}" width="97" height="46" alt="CoreUI Logo">
    </a>
    <div class="c-header px-3 font-size-20">
        <!-- Breadcrumb-->
        <ol class="breadcrumb border-0 m-0">
        @if (isset($breadcrumbs))
            @foreach ($breadcrumbs as $key => $breadcrumb)
                @if ($key != count($breadcrumbs) - 1)
                    <li class="breadcrumb-item"><a href="{{ $breadcrumb['url'] }}">{{ $breadcrumb['name'] }}</a></li>
                @else
                    <li class="breadcrumb-item active">{{ $breadcrumb }}</li>
                @endif
            @endforeach
        @endif
        <!-- Breadcrumb Menu-->
        </ol>
    </div>
    <ul class="c-header-nav ml-auto mr-6">
        <li class="c-header-nav-item d-md-down-none mx-2"><a class="c-header-nav-link">
            <svg class="c-icon" style="width:20px;height:20px;">
              <use xlink:href="{{ url('/icons/sprites/free.svg#cil-bell') }}"></use>
            </svg></a></li>
            <li class="vertical"></li>
        <li class="c-header-nav-item dropdown d-md-down-none">
            <form action="{{ url('/logout') }}" method="POST">
                @csrf
                <button type="submit" class="btn btn-ghost-dark btn-block btn-hover">
                    <svg class="c-icon mr-1" style="width: 14px;height:14px;">
                        <use xlink:href="{{ url('/icons/sprites/free.svg#cil-account-logout') }}"></use>
                      </svg>
                    ログアウト
                </button>
            </form>
        </li>
    </ul>
</header>
