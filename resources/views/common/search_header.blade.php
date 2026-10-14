<style>
    @media (max-width:600px) {


        .input-group .btn {
            position: relative;
            z-index: 2;
            width: 60%;
        }


    }
</style>



<div class="bg-scr-none">
    <div class="main-content">
        <div class="page-content pb-0 mb-0">
            <div class="container-fluid">
                <div class="row fd-col">

                    <?php $session1 = auth()->user(); ?>
                    @if ($session1->role_id == 2)
                        <div class="col-md-6 mb-2 d-flex">
                            <form class="d-flex f-d-col" method="post" action="{{ route('Membersearch.index') }}">
                                @csrf
                                <div class="input-group mx-2 w-100">
                                    <input type="text" class="form-control" name="first_name" placeholder="Search"
                                        id="first_name" value="<?= isset($first_name1) ? $first_name1 : '' ?>">
                                </div>
                                <div class="input-group mx-2 w-100">
                                    <select class="form-select" id="category_id" name="category_id">
                                        <option value="">Select Category</option>
                                        @php
                                            $search = \App\Models\Categories::select('categories.id', 'categories.name')
                                                ->where(['iStatus' => 1, 'isDelete' => 0])
                                                ->get();
                                        @endphp
                                        @foreach ($search as $categori)
                                            <option value="{{ $categori->id }}"
                                                {{ isset($category_id) && $categori->id == $category_id ? 'selected' : '' }}>
                                                {{ $categori->name }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>

                                <div class="input-group w-10">
                                    <input type="submit" id="search" class="btn btn-success" name="search"
                                        title="Search" value="Search">
                                </div>
                            </form>
                        </div>

                    @endif


                </div>
            </div>
        </div>
    </div>
</div>
