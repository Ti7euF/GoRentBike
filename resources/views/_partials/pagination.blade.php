<nav class="paginate">
    <ul>
        <li class="{{ $currentPage == 1 ? 'disabled' : '' }}">
            <a href="javascript:void(0)" onclick="{{ $currentPage == 1 ? '' : 'changePage(1)' }}">
                <i class="fa-solid fa-angles-left"></i>
            </a>
        </li>

        <li class="{{ $currentPage == 1 ? 'disabled' : '' }}">
            <a href="javascript:void(0)" onclick="{{ $currentPage == 1 ? '' : 'changePage(' . ($currentPage - 1) . ')' }}">
                <i class="fa-solid fa-angle-left"></i>
            </a>
        </li>

        <li class="activo">
            <a>{{ $currentPage }} de {{ $totalPages }} páginas</a>
        </li>

        <li class="{{ $currentPage == $totalPages ? 'disabled' : '' }}">
            <a href="javascript:void(0)" onclick="{{ $currentPage == $totalPages ? '' : 'changePage(' . ($currentPage + 1) . ')' }}">
                <i class="fa-solid fa-angle-right"></i>
            </a>
        </li>

        <li class="{{ $currentPage == $totalPages ? 'disabled' : '' }}">
            <a href="javascript:void(0)" onclick="{{ $currentPage == $totalPages ? '' : 'changePage(' . $totalPages . ')' }}">
                <i class="fa-solid fa-angles-right"></i>
            </a>
        </li>
    </ul>
</nav>