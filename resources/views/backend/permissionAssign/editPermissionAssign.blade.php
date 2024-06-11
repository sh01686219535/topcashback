 @extends('backend.layouts.app')
 @section('title')
      Assign Permission
 @endsection
 @section('content')
     <div class="container customer-container">
         <div class="row">
             <div class="col-lg-12">
                 <div class="card mb-2">
                     <div class="card-head mx-5 my-3 customer-card">
                         <div class="left">
                             <h3>Assign Permission Create</h3>
                         </div>
                         <div class="search">
                             <a href="{{route('access-control')}}" class="btn btn-primary" title="Add Category">
                                 <i class="fa-sharp fa-solid fa-list"></i>
                                 Assign Permission</a>
                         </div>
                     </div>
                 </div>
                 @include('error')
                 <div class="card">
                     <div class="card-body">
                        <div class="col-lg-6">
                         <form  action="{{ route('edit-assign-permission') }}" method="POST">
                             @csrf
                             <input type="hidden" name="permission_assign_id" value="{{ $id }}">
                             <div class="form-group">
                                 <label for="role">Role</label>
                                 <select class="form-control my-3" name="role_id" id="">
                                 <option value="">--Select Role--</option>


                                     @foreach($role as $roles)

                                         <option value="{{ $roles->id }}" {{ $roles->id == $roleToEdit->id ? 'selected' : ''}}>
                                            {{ $roles->role_name }}
                                        </option>
                                     @endforeach
                                 </select>
                             </div>
                             <div class="form-group">
                                 <label for="permission">Permissions</label>

                                 <div class="form-check">
                                     <label for="check_permissionAll">All</label>
                                     <input type="checkbox" name="all_id[]" id="check_permissionAll" class="form-check-input" value="1">
                                 </div>
                                 <hr>
                                 @php
                                  $i =1;
                                 @endphp
                                 @foreach ($module as $modules)
                                 @foreach($modules->subModule as $subModule)

                                     <div class="row">
                                         <div class="col-3">
                                             <div class="form-check">
                                                 <label for="exam-check">{{$subModule->subModule_name}}</label>
                                                 <input type="checkbox" name="submodule_id[]" id="{{ $i }}Management" class="form-check-input" value="{{$subModule->subModule_name}}" onclick="checkPermissionByGroup('rol-{{ $i }}-management-checkbox', this)">
                                             </div>
                                         </div>
                                         <div class="col-9 rol-{{ $i }}-management-checkbox">
                                             @php
                                                 $j = 1;
                                             @endphp
                                             @foreach($subModule->permission as $permissions)
                                                 <div class="form-check">
                                                     <label for="exam-check{{$permissions->id}}">{{$permissions->permission_name}}</label>
                                                     <input type="checkbox" name="permission_id[]" id="exam-check{{$permissions->id}}" class="form-check-input" value="{{$permissions->id}}" {{ in_array($permissions->id,$permarray) ? "checked" :'' }} >
                                                     <span class="checkmark"></span>
                                                     {{-- {{ $permissions->permission_name }} --}}
                                                 </div>
                                                 @php
                                                     $j++;
                                                 @endphp
                                             @endforeach
                                         </div>
                                     </div>
                                     <hr>
                                     @php
                                         $i++;
                                     @endphp
                                 @endforeach
                             @endforeach
                             </div>
                             <input type="submit" value="Submit" class="btn btn-success">
                         </form>
                        </div>

                     </div>
                 </div>
             </div>
         </div>
     </div>
 @endsection
 @push('js')
     <script>
         $(document).ready(function(){
            $('#check_permissionAll').click(function(){
                 if($(this).is(':checked')){
                     $('input[type=checkbox]').prop('checked',true);
                 }else{
                     $('input[type=checkbox]').prop('checked',false);
                 }
            });
         });
         function checkPermissionByGroup(className, checkThis){
             const groupIdName = $("#"+checkThis.id);
             const classCheckBox = $('.'+className+' input');
             if(groupIdName.is(':checked')){
                 classCheckBox.prop('checked', true);
             }else{
                 classCheckBox.prop('checked', false);
             }
         }
     </script>
 @endpush









