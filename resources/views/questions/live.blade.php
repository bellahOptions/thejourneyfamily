@extends('layouts.app', ['title' => 'Live questions — '.config('retreat.name')])

@section('body')
    <main class="flex min-h-screen flex-col bg-gray-950 text-white">
        <header class="flex items-center justify-between px-10 py-8">
            <img src="{{ asset('logo.png') }}" alt="{{ config('retreat.name') }}" class="h-10 w-auto opacity-80">
            <p class="text-xs font-semibold uppercase tracking-[0.32em] text-[#f0b65b]">Live Q&amp;A</p>
        </header>

        <div id="question-stage" class="flex flex-1 flex-col items-center justify-center px-10 text-center sm:px-24">
            <p id="question-empty" class="max-w-2xl font-display text-3xl text-white/40">
                No questions on screen yet — send yours in at
                <span class="text-[#f0b65b]">{{ route('questions.create') }}</span>
            </p>
            <p id="question-text" class="hidden max-w-4xl font-display text-4xl font-semibold leading-tight sm:text-6xl"></p>
        </div>

        <footer class="flex items-center justify-center gap-2 pb-10">
            <span id="question-dots" class="flex gap-2"></span>
        </footer>
    </main>

    <script>
        (function () {
            const textEl = document.getElementById('question-text');
            const emptyEl = document.getElementById('question-empty');
            const dotsEl = document.getElementById('question-dots');

            let questions = [];
            let index = 0;

            function render() {
                if (questions.length === 0) {
                    textEl.classList.add('hidden');
                    emptyEl.classList.remove('hidden');
                    dotsEl.innerHTML = '';
                    return;
                }

                emptyEl.classList.add('hidden');
                textEl.classList.remove('hidden');
                textEl.style.opacity = 0;

                window.setTimeout(() => {
                    textEl.textContent = questions[index].body;
                    textEl.style.transition = 'opacity 600ms ease';
                    textEl.style.opacity = 1;
                }, 150);

                dotsEl.innerHTML = '';
                questions.forEach((_, i) => {
                    const dot = document.createElement('span');
                    dot.className = 'h-1.5 w-1.5 rounded-full ' + (i === index ? 'bg-[#f0b65b]' : 'bg-white/20');
                    dotsEl.appendChild(dot);
                });
            }

            function advance() {
                if (questions.length === 0) {
                    return;
                }
                index = (index + 1) % questions.length;
                render();
            }

            async function refresh() {
                try {
                    const response = await fetch('{{ route('questions.live-data') }}', {
                        headers: { Accept: 'application/json' },
                    });
                    const data = await response.json();
                    const incoming = data.questions ?? [];

                    if (JSON.stringify(incoming.map((q) => q.id)) !== JSON.stringify(questions.map((q) => q.id))) {
                        questions = incoming;
                        index = 0;
                        render();
                    }
                } catch (error) {
                    // Network hiccup — keep showing the last known questions.
                }
            }

            refresh();
            window.setInterval(refresh, 8000);
            window.setInterval(advance, 7000);
        })();
    </script>
@endsection
