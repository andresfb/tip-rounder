<article class="content">
    <div class="w-80 lg:w-96">
        <ul class="list bg-base-100 shadow-sm rounded-box">

            <li class="p-4 pb-2 text-xs opacity-60 tracking-wide">Results</li>

            <li class="list-row">
                <div class="font-thin opacity-60 tabular-nums">Bill</div>
                <div class="list-col-grow">
                    <div class="text-3xl font-mono font-medium">${{ number_format($bill, 2) }}</div>
                </div>
            </li>

            <li class="p-4 pb-2 text-xs opacity-60 tracking-wide">Tip Roundings</li>

            <li class="list-row">
                <div class="font-thin opacity-60 tabular-nums">Exact</div>
                <div class="text-3xl font-mono font-medium">${{ number_format($tip, 2) }}</div>
                <div class="list-col-grow">
                    <div>Total: <span class="font-mono font-medium">${{ number_format($total, 2) }}</span></div>
                    <div class="text-xs uppercase font-semibold opacity-60">{{ number_format($tipPercent, 2) }}%</div>
                </div>
            </li>

            <li class="list-row">
                <div class="font-thin opacity-60 tabular-nums">Upper</div>
                <div class="text-3xl font-mono font-medium">${{ number_format($upperTip, 2) }}</div>
                <div class="list-col-grow">
                    <div>Total: <span class="font-mono font-medium">${{ number_format($upperTotal, 2) }}</span></div>
                    <div class="text-xs uppercase font-semibold opacity-60">{{ number_format($upperTipPercent, 2) }}%</div>
                </div>
            </li>

            <li class="list-row">
                <div class="font-thin opacity-60 tabular-nums">Lower</div>
                <div class="text-3xl font-mono font-medium">${{ number_format($lowerTip, 2) }}</div>
                <div class="list-col-grow">
                    <div>Total: <span class="font-mono font-medium">${{ number_format($lowerTotal, 2) }}</span></div>
                    <div class="text-xs uppercase font-semibold opacity-60">{{ number_format($lowerTipPercent, 2) }}%</div>
                </div>
            </li>

            <li class="list-row">
                <a href="{{ route('home') }}" class="btn btn-secondary mt-4">Try Another</a>
            </li>


        </ul>
    </div>
</article>
