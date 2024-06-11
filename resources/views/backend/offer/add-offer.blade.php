@extends('backend.layouts.app')
@section('title')
Add Offer
@endsection
@push('css')
<style>
    .disabled{
        display: none;
    }
    .disabled-1{
        display: none;
    }
</style>
@endpush
@section('content')
<!-- Hoverable Table rows -->
<div class="contasiner customer-container">
   <div class="row">
      <div class="col-lg-12">
         <div class="card mb-2">
            <div class="card-head mx-5 my-3 customer-card">
               <div class="left">
                  @if($advertisement)
                     <h3>Add Creation</h3>
                  @else
                     <h3>Offer Creation</h3>
                  @endif
               </div>
               <div class="search">
                  <a href="{{route('offer')}}" class="btn btn-primary" title="Add Category">
                  <i class="fa-sharp fa-solid fa-list"></i>
                  Offer List</a>
               </div>
            </div>
         </div>
      </div>
   </div>
   <div class="row">
   @include('error')
      <div class="card">
      <div class="col-lg-12">
         <div class="card-body">
         <form class="form_1" action="{{route('save.offer')}}" method="post" enctype="multipart/form-data">
            @csrf
            <div class="row">
                     <div class="col-lg-4">
                           @if($advertisement)
                           <div class="form-group">
                              <label for="placeName"><strong>Add Location</strong></label>
                              <select id="placeName" name="placeName" class="form-select my-2">
                                 <option selected="">Select A Place Name</option>
                                 @foreach($RateOff as $item1)
                                 <option value="{{$item1->id}}">{{$item1->placeName}}</option>
                                 @endforeach
                              </select>
                           </div>
                           @else
                           @endif
                     </div>
                     <div class="col-lg-4">
                           @if($advertisement)
                           <div class="form-group">
                                 <label for="
                                 "><strong>Price</strong></label>
                                 <select id="placeRate" name="placeRate" class="form-select my-2 ">
                                    <option selected="">Select A Place Rate</option>
                                 </select>
                              </div>
                              @else
                              @endif
                     </div>
                     </div>
            <div class="row">
               <div class="col-md-4">
                  <div class="form-group">
                     <label for="category_id"><strong>Category Name</strong></label>
                     <select id="category_id" name="category_id" class="form-select my-2">
                        <option selected="">Select A Category</option>
                        @foreach($category as $item)
                        <option value="{{$item->id}}">{{$item->category_name}}</option>
                        @endforeach
                     </select>
                  </div>
               </div>
               <div class="col-md-4">
                  <div class="form-group">
                     <label for="subCategory_id">Sub Category Name</label>
                     <select id="subCategory_id" name="subCategory_id" class="form-select my-2">
                        <option value="">Select A Sub Category</option>
                     </select>
                  </div>
               </div>
               <div class="col-md-4">
                  <div class="form-group">
                     <label for="merchant_address">Merchant Area</label>
                     <select id="merchant_address" name="merchant_id" class="form-select my-2 ">
                        <option selected="">Select A Merchant Area</option>
                        @foreach($merchant as $merchants)
                           <option value="{{$merchants->id}}">{{$merchants->areas->areaName}}</option>
                        @endforeach
                     </select>
                  </div>
               </div>
               <div class="col-md-4">
                  <div class="form-group">
                     <label for="brand_name">Company Name</label>
                     <select id="brand_name" name="brand_name" class="form-select my-2">
                     <option value="">Select A Brand Name</option>
                        @foreach($merchant as $item1)
                        <option value="{{$item1->id}}">{{$item1->company_name}}</option>
                        @endforeach
                     </select>
                  </div>
               </div>
               <div class="col-md-4">
                  <div class="form-group">
                     <label for="offer_title">Offer Title</label>
                     <input type="text" id="offer_title" name="offer_title" placeholder="Offer Title" class="form-control my-2">
                  </div>
               </div>
               <div class="col-md-4">
                  <div class="form-group">
                     <label for="banner_image">Banner Image</label>
                     <input type="file" id="banner_image" name="banner_image" class="form-control my-2">
                  </div>
               </div>
               <div class="col-lg-8">
                <div class="control">
                    <div class="form-check form-check-inline my-2">
                        <input class="form-check-input" type="radio" name="fixed_amount" id="fixed_amount_offer">
                        Fixed Amount
                        <label class="form-check-label" for="inlineRadio1"></label>
                    </div>
                    <div class="form-check form-check-inline my-2">
                        <input class="form-check-input" type="radio" name="percentage_amount" id="percentage_amount_offer" >
                        Percentage Amount
                        <label class="form-check-label" for="inlineRadio2"></label>
                    </div>
                    <div>
                        {{-- <input type="text" class="disabled-1 form-control" id="fixed_amount" name="fixed_amount" placeholder="Enter your Fixed Commission"> --}}
                        <input type="text" id="fixed_amount" name="offer_amount" placeholder="Enter Flate Amount" class="form-control my-2 disabled-1"  placeholder="Offer Amount">
                        <input type="text" id="percentage_amount" name="offer_percentage" placeholder="Enter Percentage Amount" class="form-control my-2 disabled">
                        {{-- <input type="text" class="disabled form-control" id="percentage_amount" name="percentage_amount" placeholder="Enter your Percentage Commission" > --}}
                    </div>
                </div>
                </div>
               {{-- <div class="col-md-4">
                  <div class="form-group">
                     <label for="offer_percentage">Offer Percentage</label>
                     <input type="text" id="offer_percentage" name="offer_percentage" value="0" class="form-control my-2">
                  </div>
               </div> --}}
               {{-- <div class="col-md-4">
                  <div class="form-group">
                     <label for="offer_amount">Offer Amount</label>
                     <input type="text" id="offer_amount" name="offer_amount" value="0" class="form-control my-2"  placeholder="Offer Amount">
                  </div>
               </div> --}}
               <div class="col-md-4">
                  <div class="form-group">
                     <label for="offer_image">Offer Image</label>
                     <input type="file" id="offer_image" name="offer_image" class="form-control my-2">
                  </div>
               </div>
               <div class="col-md-4">
                  <div class="form-group">
                     <label for="minimum_perchase">Minimum Purchase Requirment</label>
                     <input type="text" id="minimum_perchase" name="minimum_perchase" class="form-control my-2"  placeholder="Enter Minimum Purchase Requirment">
                  </div>
               </div>
               <div class="col-md-8">
                  <div class="form-group">
                     <label for="offer_description" class="my-2">Offer Description</label>
                     <textarea type="text" id="offer_description" name="offer_description" class="form-control my-2"></textarea>
                  </div>
               </div>
               <div class="form-group text-center">
                  @if($advertisement)
                     <input type="submit" value="Save & Pay" class=" my-2 btn btn-info btn-submit">
                  @else
                     <input type="submit" value="Save Offer" class=" my-2 btn btn-info btn-submit">
                  @endif
               </div>
            </div>
         </form>
         </div>
      </div>
      </div>
   </div>
</div>
<script src="https://code.jquery.com/jquery-3.7.1.min.js" integrity="sha256-/JqT3SQfawRcv/BIHPThkBvs0OEvtFFmqPF/lYI/Cxo=" crossorigin="anonymous"></script>
<script>
   $(document).ready(function () {
       $('#category_id').change(function () {
           var category_id = $(this).val();
           $.ajax({
               url: '/get-category',
               type: 'post',
               dataType: 'json',
               data:'category_id='+category_id,
               success: function (data) {
                   $('#subCategory_id').html(data);
               },
               error: function (xhr, status, error) {
                   console.error(xhr.responseText);
               }
           });
       });
   });
   $(document).ready(function () {
       $('#merchant_address').change(function () {
           var merchant_id = $(this).val();
           $.ajax({
               url: '/get-merchant',
               type: 'post',
               dataType: 'json',
               data:'merchant_id='+merchant_id,
               success: function (data) {
                   $('#brand_name').html(data);
               },
               error: function (xhr, status, error) {
                   console.error(xhr.responseText);
               }
           });
       });
   });
   $(document).ready(function () {
       $('#placeName').change(function () {
           var placeName_id = $(this).val();
           $.ajax({
               url: '/get-placeName',
               type: 'post',
               dataType: 'json',
               data:'placeName_id='+placeName_id,
               success: function (data) {
                   $('#placeRate').html(data);
               },
               error: function (xhr, status, error) {
                   console.error(xhr.responseText);
               }
           });
       });
   });

</script>
<script>
    $(document).ready(function(){
    $('#fixed_amount_offer').click(function(){
        $('#fixed_amount').css("display", "block");
        $('#percentage_amount').hide();
        $("#percentage_amount_offer").prop( "checked", false );
        $(this).prop( "checked", true );
    });
    $('#percentage_amount_offer').click(function(){
        $('#percentage_amount').css("display", "block");
        $('#fixed_amount').hide();
        $("#fixed_amount_offer").prop( "checked", false );
        $(this).prop( "checked", true );
    });
});
</script>
@endsection

@push('js')
<!--/ Hoverable Table rows -->

<!-- Ck Editer -->
<script src="https://cdn.ckeditor.com/ckeditor5/34.1.0/super-build/ckeditor.js"></script>

<script>
    // This sample still does not showcase all CKEditor 5 features (!)
    // Visit https://ckeditor.com/docs/ckeditor5/latest/features// to browse all the features.
    CKEDITOR.ClassicEditor.create(document.getElementById("offer_description"), {
        // https://ckeditor.com/docs/ckeditor5/latest/features/toolbar/toolbar.html#extended-toolbar-configuration-format
        toolbar: {
            items: [
                'exportPDF','exportWord', '|',
                'findAndReplace', 'selectAll', '|',
                'heading', '|',
                'bold', 'italic', 'strikethrough', 'underline', 'code', 'subscript', 'superscript', 'removeFormat', '|',
                'bulletedList', 'numberedList', 'todoList', '|',
                'outdent', 'indent', '|',
                'undo', 'redo',
                '-',
                'fontSize', 'fontFamily', 'fontColor', 'fontBackgroundColor', 'highlight', '|',
                'alignment', '|',
                'link', 'insertImage', 'blockQuote', 'insertTable', 'mediaEmbed', 'codeBlock', 'htmlEmbed', '|',
                'specialCharacters', 'horizontalLine', 'pageBreak', '|',
                'textPartLanguage', '|',
                'sourceEditing'
            ],
            shouldNotGroupWhenFull: true
        },
        // Changing the language of the interface requires loading the language file using the <script> tag.
        // language: 'es',
        list: {
            properties: {
                styles: true,
                startIndex: true,
                reversed: true
            }
        },
        // https://ckeditor.com/docs/ckeditor5/latest/features/headings.html#configuration
        heading: {
            options: [
                { model: 'paragraph', title: 'Paragraph', class: 'ck-heading_paragraph' },
                { model: 'heading1', view: 'h1', title: 'Heading 1', class: 'ck-heading_heading1' },
                { model: 'heading2', view: 'h2', title: 'Heading 2', class: 'ck-heading_heading2' },
                { model: 'heading3', view: 'h3', title: 'Heading 3', class: 'ck-heading_heading3' },
                { model: 'heading4', view: 'h4', title: 'Heading 4', class: 'ck-heading_heading4' },
                { model: 'heading5', view: 'h5', title: 'Heading 5', class: 'ck-heading_heading5' },
                { model: 'heading6', view: 'h6', title: 'Heading 6', class: 'ck-heading_heading6' }
            ]
        },
        // https://ckeditor.com/docs/ckeditor5/latest/features/editor-placeholder.html#using-the-editor-configuration
        placeholder: 'page contenet will be here...!',
        name: 'description',
        // https://ckeditor.com/docs/ckeditor5/latest/features/font.html#configuring-the-font-family-feature
        fontFamily: {
            options: [
                'default',
                'Arial, Helvetica, sans-serif',
                'Courier New, Courier, monospace',
                'Georgia, serif',
                'Lucida Sans Unicode, Lucida Grande, sans-serif',
                'Tahoma, Geneva, sans-serif',
                'Times New Roman, Times, serif',
                'Trebuchet MS, Helvetica, sans-serif',
                'Verdana, Geneva, sans-serif'
            ],
            supportAllValues: true
        },
        // https://ckeditor.com/docs/ckeditor5/latest/features/font.html#configuring-the-font-size-feature
        fontSize: {
            options: [ 10, 12, 14, 'default', 18, 20, 22 ],
            supportAllValues: true
        },
        // Be careful with the setting below. It instructs CKEditor to accept ALL HTML markup.
        // https://ckeditor.com/docs/ckeditor5/latest/features/general-html-support.html#enabling-all-html-features
        htmlSupport: {
            allow: [
                {
                    name: /.*/,
                    attributes: true,
                    classes: true,
                    styles: true
                }
            ]
        },
        // Be careful with enabling previews
        // https://ckeditor.com/docs/ckeditor5/latest/features/html-embed.html#content-previews
        htmlEmbed: {
            showPreviews: true
        },
        // https://ckeditor.com/docs/ckeditor5/latest/features/link.html#custom-link-attributes-decorators
        link: {
            decorators: {
                addTargetToExternalLinks: true,
                defaultProtocol: 'https://',
                toggleDownloadable: {
                    mode: 'manual',
                    label: 'Downloadable',
                    attributes: {
                        download: 'file'
                    }
                }
            }
        },
        // https://ckeditor.com/docs/ckeditor5/latest/features/mentions.html#configuration
        mention: {
            feeds: [
                {
                    marker: '@',
                    feed: [
                        '@apple', '@bears', '@brownie', '@cake', '@cake', '@candy', '@canes', '@chocolate', '@cookie', '@cotton', '@cream',
                        '@cupcake', '@danish', '@donut', '@dragée', '@fruitcake', '@gingerbread', '@gummi', '@ice', '@jelly-o',
                        '@liquorice', '@macaroon', '@marzipan', '@oat', '@pie', '@plum', '@pudding', '@sesame', '@snaps', '@soufflé',
                        '@sugar', '@sweet', '@topping', '@wafer'
                    ],
                    minimumCharacters: 1
                }
            ]
        },
        // The "super-build" contains more premium features that require additional configuration, disable them below.
        // Do not turn them on unless you read the documentation and know how to configure them and setup the editor.
        removePlugins: [
            // These two are commercial, but you can try them out without registering to a trial.
            // 'ExportPdf',
            // 'ExportWord',
            'CKBox',
            'CKFinder',
            'EasyImage',
            // This sample uses the Base64UploadAdapter to handle image uploads as it requires no configuration.
            // https://ckeditor.com/docs/ckeditor5/latest/features/images/image-upload/base64-upload-adapter.html
            // Storing images as Base64 is usually a very bad idea.
            // Replace it on production website with other solutions:
            // https://ckeditor.com/docs/ckeditor5/latest/features/images/image-upload/image-upload.html
            // 'Base64UploadAdapter',
            'RealTimeCollaborativeComments',
            'RealTimeCollaborativeTrackChanges',
            'RealTimeCollaborativeRevisionHistory',
            'PresenceList',
            'Comments',
            'TrackChanges',
            'TrackChangesData',
            'RevisionHistory',
            'Pagination',
            'WProofreader',
            // Careful, with the Mathtype plugin CKEditor will not load when loading this sample
            // from a local file system (file://) - load this site via HTTP server if you enable MathType
            'MathType'
        ]
    });
</script>
@endpush
