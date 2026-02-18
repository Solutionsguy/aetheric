
<div class="{{ $me ? 'main-referral-tree-item-parent' : 'main-referral-tree-item tree-children' }}">
    <div class="main-referral-tree-card {{ $me ? ' tree-parent' : '' }}">
        <div class="thumb">
            <img src="{{ $levelUser->avatar_path }}" alt="profile tree">
        </div>
        <div class="content">
            <h5 class="title">
                @if($me)
                    {{ __("It's Me") }} ({{ $levelUser->full_name }})
                @else
                    <b>{{ $levelUser->full_name }}</b>
                @endif
            </h5>
            @if(!$me)
            <p class="info">
                {{ __('Deposit') }} : {{ $currencySymbol.$levelUser->total_deposit }}
            </p>
            @endif
        </div>
    </div>
</div>

@if($depth && $level >= $depth && $levelUser->referrals->count() > 0)
    <ul>
        @foreach($levelUser->referrals as $childUser)
            <li class="child">
                <div class="main-referral-tree-item tree-children">
                    <div class="main-referral-tree-card-inner">
                        <!-- Recursively include children -->
                        @include('frontend::referral.include.__tree', [
                            'levelUser' => $childUser, 
                            'level' => $level, 
                            'depth' => $depth + 1, 
                            'me' => false
                        ])
                    </div>
                </div>
            </li>
        @endforeach
    </ul>
@endif

