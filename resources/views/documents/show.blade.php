@section('site_title', formatTitle([e($document->name), __('Document'), config('settings.title')]))

@include('shared.breadcrumbs', ['breadcrumbs' => [
    ['url' => request()->is('admin/*') ? route('admin.dashboard') : route('dashboard'), 'title' => request()->is('admin/*') ? __('Admin') : __('Home')],
    ['url' => request()->is('admin/*') ? route('admin.documents') : route('documents'), 'title' => __('Documents')],
    ['title' => __('Document')],
]])

<div class="d-flex align-items-end mb-3">
    <h1 class="h2 mb-0 flex-grow-1 text-truncate">{{ __('Document') }}</h1>

    <div class="d-flex align-items-center flex-grow-0">
        <div class="form-row flex-nowrap">
            <div class="col">
                <form action="{{ route('documents.edit', $document->id) }}" method="post" enctype="multipart/form-data">
                    @csrf
                    <textarea name="result" id="i-result-{{ $document->id }}" class="d-none">
                        {!! clean(encodeQuill($document->result)) !!}
                    </textarea>

                    <button type="submit" class="btn d-flex align-items-center" data-tooltip="true" title="{{ __('Save') }}">@include('icons.save', ['class' => 'fill-current width-4 height-4 text-secondary'])
                        &#8203;
                    </button>
                </form>
            </div>
            <div class="col">
                <button class="btn d-flex align-items-center" data-tooltip-copy="true" title="{{ __('Copy') }}" data-text-copy="{{ __('Copy') }}" data-text-copied="{{ __('Copied') }}" data-clipboard="true" data-clipboard-target="#result-{{ $document->id }}">
                    @include('icons.content-copy', ['class' => 'fill-current width-4 height-4 text-secondary'])&#8203;
                </button>
            </div>
            <div class="col">
                <a href="#" class="btn text-secondary d-flex align-items-center" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">@include('icons.more-horiz', ['class' => 'fill-current width-4 height-4'])
                    &#8203;</a>

                @include('documents.partials.menu')
            </div>
        </div>
    </div>
</div>

<div class="card border-0 rounded-top shadow-sm overflow-hidden">
    <div class="px-3 border-bottom">
        <div class="row">
            <!-- Title -->
            <div class="col-auto d-flex align-items-center {{ (__('lang_dir') == 'rtl' ? 'border-left' : 'border-right') }}">
                <div class="px-2 py-4 d-flex">
                    <div class="d-flex position-relative width-10 height-10 align-items-center justify-content-center flex-shrink-0 text-{{ categoryColor($document->template->category_id) }}">
                        <div class="position-absolute opacity-10 top-0 right-0 bottom-0 left-0 border-radius-xl bg-{{ categoryColor($document->template->category_id) }}"></div>

                        @if($document->template->isCustom())
                            <span class="user-select-none font-size-xl">{{ $document->template->icon }}</span>
                        @else
                            @include('icons.' . $document->template->icon, ['class' => 'fill-current width-5 height-5'])
                        @endif
                    </div>
                </div>
            </div>

            <div class="col">
                <div class="row">
                    <!-- Name -->
                    <div class="col-12 col-md-6 col-xl-3 {{ (__('lang_dir') == 'rtl' ? 'border-left-md' : 'border-right-md')  }}">
                        <div class="px-2 py-4">
                            <div class="text-muted mb-1">
                                {{ __('Name') }}
                            </div>
                            <div class="h6 font-weight-bold mb-0 text-truncate">
                                <div class="d-flex align-items-center text-truncate">
                                    <div class="text-truncate">{{ $document->name }}</div>

                                    @if($document->favorite)
                                        <div class="d-flex flex-shrink-0 width-4 height-4 text-warning {{ (__('lang_dir') == 'rtl' ? 'mr-2' : 'ml-2') }}" data-tooltip="true" title="{{ __('Favorite') }}">@include('icons.star', ['class' => 'fill-current width-4 height-4 flex-shrink-0'])</div>
                                    @endif
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Template -->
                    <div class="col-12 d-none d-xl-flex col-md-6 col-xl-3 {{ (__('lang_dir') == 'rtl' ? 'border-left-md' : 'border-right-md')  }}">
                        <div class="px-2 py-4">
                            <div class="text-muted mb-1">
                                {{ __('Template') }}
                            </div>

                            <div class="d-flex align-items-center h6 font-weight-bold mb-0 text-truncate">
                                <span class="text-truncate" data-tooltip="true" title="{{ __($document->template->name) }}">
                                    <a href="{{ $document->template->url }}" class="text-body">{{ __($document->template->name) }}</a>
                                </span>
                            </div>
                        </div>
                    </div>

                    <!-- Words -->
                    <div class="col-12 d-none d-xl-flex col-md-6 col-xl-3 {{ (__('lang_dir') == 'rtl' ? 'border-left-md' : 'border-right-md')  }}">
                        <div class="px-2 py-4">
                            <div class="text-muted mb-1">
                                <div class="d-flex text-truncate">
                                    <div class="text-truncate">{{ __('Words') }}</div>
                                    <div class="flex-shrink-0 d-flex align-items-center {{ (__('lang_dir') == 'rtl' ? 'mr-2' : 'ml-2') }}"
                                        data-tooltip="true" title="{{ __('The number of words generated by the AI.') }} {{ __('Some language systems will use the following symbol to word ratios: :ratios.', ['ratios' => implode(', ', array_map(function($ratio) { return __(':ratio :scripts', ['ratio' => $ratio['value'], 'scripts' => '(' . implode(', ', array_map(function ($script) { return __($script); }, $ratio['scripts'])) . ')']); }, config('completions.ratios')))]) }}">
                                        @include('icons.info', ['class' => 'width-4 height-4 fill-current text-muted'])
                                    </div>
                                </div>
                            </div>
                            <div class="d-flex align-items-center h6 font-weight-bold mb-0 text-truncate">
                                <span class="text-truncate" data-tooltip="true" title="{{ ($document->words > 1 ? __(':number words', ['number' => number_format($document->words, 0, __('.'), __(','))]) : __(':number word', ['number' => number_format($document->words, 0, __('.'), __(','))])) }}">
                                    {{ ($document->words > 1 ? __(':number words', ['number' => number_format($document->words, 0, __('.'), __(','))]) : __(':number word', ['number' => number_format($document->words, 0, __('.'), __(','))])) }}
                                </span>
                            </div>
                        </div>
                    </div>

                    <!-- Created at -->
                    <div class="col-12 d-none d-md-flex col-md-6 col-xl-3">
                        <div class="px-2 py-4">
                            <div class="text-muted mb-1">
                                {{ __('Created at') }}
                            </div>
                            <div class="d-flex align-items-center h6 font-weight-bold mb-0 text-truncate">
                                <div class="text-truncate" data-tooltip="true" title="{{ $document->created_at->tz(Auth::user()->timezone ?? config('app.timezone'))->format(__('Y-m-d') . ' H:i:s') }}">{{ $document->created_at->diffForHumans() }}</div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="card-header d-flex">
        <div class="py-1">
            @include('documents.partials.editor.toolbar')
        </div>
    </div>
    <div class="card-body p-3">
        <div class="form-group m-0 p-1">
            <div class="form-control height-auto {{ $errors->has('result') ? ' is-invalid' : ' p-0 border-0' }}">
                @include('documents.partials.editor.content')
            </div>
            @if ($errors->has('result'))
                <span class="invalid-feedback" role="alert">
                    <strong>{{ $errors->first('result') }}</strong>
                </span>
            @endif
        </div>
    </div>
</div>
