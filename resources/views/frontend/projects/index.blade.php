<x-frontend::layout :profile="$profile" :seo="$seo">
            <section class="section-pad muted-band projects-page-section" id="all-projects" aria-labelledby="all-projects-title">
                <div class="container">
                    <div class="section-heading center reveal">
                        <p class="eyebrow">All projects</p>
                        <h1 id="all-projects-title" class="page-title">Production platforms, commerce systems, and backend workflows.</h1>
                        <p class="page-lede">
                            A selection of professional and personal work built with Laravel, PHP, MySQL, Redis, Blade, and payment integrations.
                        </p>
                    </div>

                    <div class="project-grid all-project-grid">
                        @foreach ($projects as $project)
                            @include('frontend.partials.project-card', ['project' => $project])
                        @endforeach
                    </div>

                    @if ($projects->hasPages())
                        <nav class="pagination-shell reveal" aria-label="Projects pagination">
                            <p class="pagination-meta">
                                Showing {{ $projects->firstItem() }}-{{ $projects->lastItem() }} of {{ $projects->total() }} projects
                            </p>

                            <div class="pagination-controls">
                                @if ($projects->onFirstPage())
                                    <span class="pagination-link is-disabled" aria-disabled="true">Previous</span>
                                @else
                                    <a class="pagination-link" href="{{ $projects->previousPageUrl() }}" rel="prev">Previous</a>
                                @endif

                                <div class="pagination-pages" aria-label="Project pages">
                                    @for ($page = 1; $page <= $projects->lastPage(); $page++)
                                        @if ($page === $projects->currentPage())
                                            <span class="pagination-page is-active" aria-current="page">{{ $page }}</span>
                                        @else
                                            <a class="pagination-page" href="{{ $projects->url($page) }}">{{ $page }}</a>
                                        @endif
                                    @endfor
                                </div>

                                @if ($projects->hasMorePages())
                                    <a class="pagination-link" href="{{ $projects->nextPageUrl() }}" rel="next">Next</a>
                                @else
                                    <span class="pagination-link is-disabled" aria-disabled="true">Next</span>
                                @endif
                            </div>
                        </nav>
                    @endif
                </div>
            </section>
</x-frontend::layout>
