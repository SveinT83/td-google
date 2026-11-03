@props(['posts', 'fallbackSlugs' => [], 'limit' => 3])
@php($articles = app(\TronderData\Google\Insights::class)->popular($posts, $fallbackSlugs, $limit))
@if($articles->isNotEmpty())
<x-ui::section eyebrow="Fra fagarkivet" title="Utvalgte artikler">
<div class="card-grid">@foreach($articles as $post)<x-ui::article-card :post="$post"/>@endforeach</div>
</x-ui::section>
@endif
