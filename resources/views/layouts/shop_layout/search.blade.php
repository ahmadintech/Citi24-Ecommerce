<style>
    .search-click {
        border: 1px solid #ccc;
        outline: none;
        background-size: 22px;
        background-position: 13px;
        width: 60%;
        height: 50px;
        padding: 10px;
        transition: all 0.5s;
    }

    .search-click:focus {
        width: 80%;
    }

    .search-click {
        position: relative;
        overflow: hidden;
        height: 30px;
    }

    .search-click input {
        background: transparent;
        border: 1px solid #ccc;
        outline: none;
        position: absolute;
        width: 100px;
        height: 50px;
        left: 0%;
        padding: 10px;
    }
</style>

<form action="/shop/search/" method="get">
    <input type="text" class="search-click" name="product" placeholder="search here..." id="searchInput" />
</form>
