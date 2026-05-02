<div x-data class="modal modal-blur fade" id="editModal" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">{{__('Edit Admin')}}</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form :action="$store.editModal.formURL" method="post" @submit.prevent="$store.editModal.saveChanges">
                <div class="modal-body">
                    <div class="row">
                        <div class="col-12">
                            <div class="inline-inputs mb-3">
                                <label class="image-input user-avatar">
                                    <input hidden type="file" accept="image/*" class="avatar-input-edit"
                                           name="profile_pic">
                                    <img :src="$store.editModal.profile_pic" class="avatar-img-edit" alt="">
                                    <div class="overlay-icon">
                                        <svg xmlns="http://www.w3.org/2000/svg"
                                             class="icon icon-tabler icon-tabler-edit" width="24" height="24"
                                             viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none"
                                             stroke-linecap="round" stroke-linejoin="round">
                                            <path stroke="none" d="M0 0h24v24H0z" fill="none"/>
                                            <path d="M7 7h-1a2 2 0 0 0 -2 2v9a2 2 0 0 0 2 2h9a2 2 0 0 0 2 -2v-1"/>
                                            <path
                                                d="M20.385 6.585a2.1 2.1 0 0 0 -2.97 -2.97l-8.415 8.385v3h3l8.385 -8.415z"/>
                                            <path d="M16 5l3 3"/>
                                        </svg>
                                    </div>
                                </label>
                                <div class="form-floating">
                                    <input type="text" class="form-control" id="adminName" name="name"
                                           x-model="$store.editModal.name" placeholder="e.g. John" required>
                                    <label for="adminName">{{__('Admin name')}}</label>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col">
                                @if ($errors->has('name'))
                                    <ul class="list-unstyled text-danger mt-2">
                                        @foreach ((array) $errors->get('name') as $message)
                                            <li>{{ $message }}</li>
                                        @endforeach
                                    </ul>
                                @endif
                                @if ($errors->has('profile_pic'))
                                    <ul class="list-unstyled text-danger mt-2">
                                        @foreach ((array) $errors->get('profile_pic') as $message)
                                            <li>{{ $message }}</li>
                                        @endforeach
                                    </ul>
                                @endif
                            </div>
                        </div>
                        <div class="col-12">
                            <div class="form-floating mb-3">
                                <input type="email" class="form-control" id="adminEmail" name="email"
                                       x-model="$store.editModal.email" placeholder="name@example.com" required>
                                <label for="adminEmail">{{__('Email address')}}</label>
                                @if ($errors->has('email'))
                                    <ul class="list-unstyled text-danger mt-2">
                                        @foreach ((array) $errors->get('email') as $message)
                                            <li>{{ $message }}</li>
                                        @endforeach
                                    </ul>
                                @endif
                            </div>
                        </div>
                        <div class="col-12 col-md-6">
                            <div class="form-floating mb-3">
                                <input type="password" class="form-control" id="adminPassword" name="password"
                                       placeholder="**********" autocomplete="off">
                                <label for="adminPassword">{{__('Password')}}</label>
                            </div>
                        </div>
                        <div class=" col-12 col-md-6">
                            <div class="form-floating mb-3">
                                <input type="password" class="form-control" id="adminPasswordConfirmation"
                                       name="password_confirmation" placeholder="**********" autocomplete="off">
                                <label for="adminPasswordConfirmation">{{__('Confirm Password')}}</label>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-12">
                                <p class="text-muted pt-2">{{__('Leave it blank to keep your current password.')}}</p>
                                @if ($errors->has('password'))
                                    <ul class="list-unstyled text-danger mt-2">
                                        @foreach ((array) $errors->get('password') as $message)
                                            <li>{{ $message }}</li>
                                        @endforeach
                                    </ul>
                                @endif
                                @if ($errors->has('password_confirmation'))
                                    <ul class="list-unstyled text-danger mt-2">
                                        @foreach ((array) $errors->get('password_confirmation') as $message)
                                            <li>{{ $message }}</li>
                                        @endforeach
                                    </ul>
                                @endif
                            </div>
                        </div>
                        <div class="col-12">
                            <label class="form-check form-switch d-inline-block mb-3">
                                <input class="form-check-input" type="checkbox" name="active"
                                       :checked="$store.editModal.active" value="1">
                                <span class="form-check-label">{{__('Active')}}</span>
                            </label>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-link link-secondary" data-bs-dismiss="modal">
                        {{__('Cancel')}}
                    </button>
                    @csrf
                    @method('put')
                    <button type="submit" class="btn btn-primary ms-auto" data-bs-dismiss="modal">
                        <svg xmlns="http://www.w3.org/2000/svg" class="icon icon-tabler icon-tabler-refresh" width="24"
                             height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none"
                             stroke-linecap="round" stroke-linejoin="round">
                            <path stroke="none" d="M0 0h24v24H0z" fill="none"/>
                            <path d="M20 11a8.1 8.1 0 0 0 -15.5 -2m-.5 -4v4h4"/>
                            <path d="M4 13a8.1 8.1 0 0 0 15.5 2m.5 4v-4h-4"/>
                        </svg> {{__('Update admin')}}
                        </submit>
                    </button>

                </div>
            </form>
        </div>
    </div>
</div>
