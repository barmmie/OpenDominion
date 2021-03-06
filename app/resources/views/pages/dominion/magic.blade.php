@extends ('layouts.master')

@section('page-header', 'Magic')

@section('content')
    <div class="row">

        <div class="col-sm-12 col-md-9">
            <div class="row">

                <div class="col-md-6">
                    <div class="box box-primary">
                        <div class="box-header with-border">
                            <h3 class="box-title"><i class="ra ra-fairy-wand"></i> Self Spells <span class="label label-success">new</span></h3>
                        </div>
                        <form action="{{ route('dominion.magic') }}" method="post" role="form">
                            {!! csrf_field() !!}
                            <div class="box-body table-responsive no-padding">
                                <table class="table">
                                    <colgroup>
                                        <col width="150">
                                        <col>
                                        <col width="100">
                                        <col width="100">
                                    </colgroup>
                                    <thead>
                                        <tr>
                                            <th class="text-center">Cast Spell</th>
                                            <th>Effect</th>
                                            <th class="text-center">Active</th>
                                            <th class="text-center">Mana Cost</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($spellHelper->getSelfSpells() as $spell)
                                            @php
                                                $manaCost = ($spell['mana_cost'] * $landCalculator->getTotalLand($selectedDominion));
                                                $canCast = (($selectedDominion->resource_mana >= $manaCost) && ($selectedDominion->wizard_strength >= 30));

                                                $isActive = $spellCalculator->isSpellActive($selectedDominion, $spell['key']);

                                                if ($isActive) {
                                                    $buttonStyle = 'btn-success';
                                                } elseif ($canCast) {
                                                    $buttonStyle = 'btn-primary';
                                                } else {
                                                    $buttonStyle = 'btn-danger';
                                                }
                                            @endphp
                                            <tr>
                                                <td class="text-center">
                                                    <button type="submit" name="spell" value="{{ $spell['key'] }}" class="btn {{ $buttonStyle }} btn-block" {{ $selectedDominion->isLocked() || !$canCast ? 'disabled' : null }}>{{ $spell['name'] }}</button>
                                                </td>
                                                <td class="align-middle">{{ $spell['description'] }}</td>
                                                <td class="text-center align-middle">
                                                    @if ($isActive)
                                                        {{ $spellCalculator->getSpellDuration($selectedDominion, $spell['key']) }} hr
                                                    @else
                                                        -
                                                    @endif
                                                </td>
                                                <td class="text-center align-middle">
                                                    @if ($canCast)
                                                        <span class="text-success">{{ number_format($manaCost) }}</span>
                                                    @else
                                                        <span class="text-danger">{{ number_format($manaCost) }}</span>
                                                    @endif
                                                </td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        </form>
                    </div>
                </div>

                <div class="col-md-6">
                    <div class="box box-primary">
                        <div class="box-header with-border">
                            <h3 class="box-title"><i class="ra ra-burning-embers"></i> Offensive Spells</h3>
                        </div>
                        <div class="box-body">
                            <em>Not yet implemented</em>
                        </div>
                    </div>
                </div>

            </div>
        </div>

        <div class="col-sm-12 col-md-3">
            <div class="box">
                <div class="box-header with-border">
                    <h3 class="box-title">Information</h3>
                    <a href="{{ route('dominion.advisors.magic') }}" class="pull-right">Magic Advisor</a>
                </div>
                <div class="box-body">
                    <p>Here you may cast spells which temporarily benefit your dominion or hinder opposing dominions.</p>
                    <p>Casting spells spends some wizard strength, but it regenerates a bit every hour. You may only cast spells above 30% strength..</p>
                    <p>You have {{ number_format($selectedDominion->resource_mana) }} mana and {{ floor($selectedDominion->wizard_strength) }}% wizard strength.</p>
                </div>
            </div>
        </div>

    </div>
@endsection
