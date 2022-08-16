<nav aria-label="pagination">
    <ul class="pagination pagination-sm justify-content-center">
        <li class="page-item @if($pagination['before'] < 1) disabled @endif"><a class="page-link" href="?page={{ $pagination['before'] }}">Previous</a></li>
        @for ($i = $pagination['before']; $i <= $pagination['after']; $i++)
        @if ($pagination['after'] < $pagination['all_page'])
        <li class="page-item @if($pagination['current_page'] == $i+1) active @endif">
            <a class="page-link" href="?page={{ ($pagination['current_page'] >= $i || $pagination['after'] == $i) ? $i+1 : $i }}">
                {{ ($pagination['current_page'] >= $i || $pagination['after'] == $i) ? $i+1 : $i }}
            </a>
        </li>
        @endif
        @endfor
        <li class="page-item @if($pagination['after'] > $pagination['all_page']) disabled @endif"><a class="page-link" href="?page={{ $pagination['after'] }}">Next</a></li>
    </ul>
</nav>