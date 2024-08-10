@extends('layouts.app')

@push('styles')
<link href="{{ asset('css/jquery-ui/jquery-ui.min.css') }}" rel="stylesheet">
<link href="{{ asset('css/custom_seek.css') }}" rel="stylesheet">
<link href="{{ asset('css/customfileupload/normalize.css') }}" rel="stylesheet">
<link href="{{ asset('css/customfileupload/component.css') }}" rel="stylesheet">
<link href="{{ asset('css/intlTelInput/intlTelInput.css') }}" rel="stylesheet">
<link rel="stylesheet" href="{{ asset('css/Autocomplete-style.css') }}">
<style>
    .nav>li {
        padding-left: 20px;
        /* Indentation personnalisée */
    }

    .modal-full-height {
        height: 100%;
    }

    .modal-content {
        height: 100%;
    }

    .modal-body {
        height: calc(100% - 120px);
        /* Adjust as needed */
        overflow-y: auto;
        /* Add vertical scroll if content exceeds modal height */
    }
</style>
@endpush

@push('scripts')
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-validate/1.19.0/jquery.validate.js"></script>
<script src="/js/ad_url.js"></script>
<script src="{{ asset('js/jquery-ui/jquery-ui.min.js') }}"></script>
<script src="{{ asset('js/intlTelInput/intlTelInput.js') }}"></script>
<script src="https://cdn.jsdelivr.net/npm/places.js@1.16.1"></script>
<script src="/js/manage-step.js"></script>
<script src="/js/easyautocomplete/jquery.easy-autocomplete.min.js"></script>
<script src="/js/metro_autocomplete.js"></script>
<script src="/js/rotate-image.js"></script>
<script>
    var appSettings = {};
    var messages = {
        "rectify": "{{ __('property.rectify') }}",
        "add_saved_approb": "{{ __('backend_messages.ad_success_posted') }}",
        "data_saved": "{{ __('property.data_saved') }}",
        "error_address": "{{ __('property.error_address') }}",
        "login_success": "{{ __('property.login_success') }}",
        "phone_error": "{{ __('validator.phone_error') }}"
    }
</script>
@endpush

@include('common.fileInputMessages')

@section('content')
<section class="inner-page-wrap">
    <div class="container">
        <div class="row">
            <div class="col-xs-12 col-sm-12 col-md-10 col-md-offset-1 ">
                <div style="padding: 0">
                    <h6>Vendre un article</h6>
                </div>
                <form id="first_step" class="form-horizontal" enctype="multipart/form-data">
                    {{ csrf_field() }}
                    <div id="alert-message"></div>
                    <div class="step-content rent-property-form-content project-form white-bg m-t-20">
                        <div class="row" id="media-box-0">
                            <div class="col-md-6">
                                <label>Média Parent*</label>
                                <div class="upload-photo-outer">
                                    <div class="file-loading">
                                        <input id="file-photos" type="file" multiple class="file" data-overwrite-initial="false" name="file_photos[]" accept="image/*">
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <label>Média enfant</label>
                                <div class="upload-photo-outer">
                                    <div class="file-loading">
                                        <input id="file-photos-enfant" type="file" multiple class="file" data-overwrite-initial="false" name="file_photos[]" accept="image/*">
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="row" id="extra_new_media"></div>
                        <br>
                        <div class="row">
                            <span class="btn btn-primary" style="float:right; margin-right:20px" onclick="addMedia()">Ajouter autres media</span>
                        </div>
                    </div>

                    <br>
                    <div class="step-content rent-property-form-content project-form white-bg m-t-20" style="margin:0px">
                        <div class="form-group">
                            <label for="title" class="col-sm-2 control-label" style="text-align: start">Titre</label>
                            <div class="col-sm-10">
                                <input type="text" class="form-control" id="title" name="title" placeholder="titre" value="{{ old('title', $annonce->title ?? '') }}">
                            </div>
                        </div>
                        <hr>
                        <br>
                        <br>
                        <div class="form-group">
                            <label for="description" class="col-sm-2 control-label" style="text-align: start">Description</label>
                            <div class="col-sm-10">
                                <textarea id="description" name="description" class="form-control" placeholder="" rows="6">{{ old('description', $annonce->description ?? '') }}</textarea>
                            </div>
                        </div>
                    </div>

                    <div class="step-content rent-property-form-content project-form white-bg m-t-20">
                        <div class="form-group">
                            <label for="categorie" class="col-sm-2 control-label" style="text-align: start">Categorie</label>
                            <div class="col-sm-10">
                                <input type="text" class="form-control" id="categorie" name="categorie" value="{{ old('categorie', $annonce->categorie->name ?? '---------') }}" readonly>
                                <input type="hidden" name="categorie_id" id="categorie_id" value="{{ old('categorie_id', $annonce->categorie->id ?? '') }}">
                            </div>
                        </div>
                    </div>

                    <div class="step-content rent-property-form-content project-form white-bg m-t-20">
                        <div class="form-group">
                            <label for="prix" class="col-sm-2 control-label" style="text-align: start">Prix</label>
                            <div class="col-sm-10">
                                <input type="number" class="form-control" name="prix" id="prix" placeholder="prix" value="{{ old('prix', $annonce->prix ?? '') }}">
                            </div>
                        </div>
                        <hr>
                        <br>
                        <div class="form-group">
                            <label for="temps" class="col-sm-2 control-label" style="text-align: start">Date début</label>
                            <div class="col-sm-10">
                                <input type="date" class="form-control" id="temps" name="temps" placeholder="temps" value="{{ old('temps', $annonce->temps ?? '') }}">
                            </div>
                        </div>

                        <div class="form-group">
                            <label for="fin" class="col-sm-2 control-label" style="text-align: start">Date fin</label>
                            <div class="col-sm-10">
                                <input type="date" class="form-control" id="fin" name="fin" placeholder="temps" value="{{ old('fin', $annonce->fin ?? '') }}">
                            </div>
                        </div>

                        <div class="pr-form-ftr">
                            <div class="submit-btn-1 back-btn"><a href="{{ route('user.dashboard') }}" class="btn btn-secondary btn-lg" role="button" aria-pressed="true">Annuler</a></div>
                            <div class="submit-btn-1 save-nxt-btn">
                                <input type="submit" name="Publish" value="{{ !empty($annonce) ? __('property.save_publish') : __('property.publish') }}" id="savenext_button_st_4">
                            </div>
                        </div>
                    </div>
                </form>
                <!-- section annonce fin -->

                <!-- categorie modal -->
                <div class="modal fade" id="myModal" role="dialog">
                    <div class="modal-dialog modal-full-height">
                        <div class="modal-content">
                            <div class="modal-header">
                                <button type="button" class="close" data-dismiss="modal">&times;</button>
                                <h4 class="modal-title">Catégorie</h4>
                            </div>
                            <div class="modal-body">
                                <div id="treeview"></div>
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-default" data-dismiss="modal">Fermer</button>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- categorie modal fin -->
            </div>
        </div>
    </div>
</section>
@endsection

@push('scripts')
<script src="/js/script_media_ads.js"></script>
<script type="text/javascript">
    $(document).ready(function() {
        // Your existing code for initialization
        $('#first_step').submit(function(event) {
            event.preventDefault();
            submit_ads($(this));
        });
    });

    function submit_ads(form) {
        form.find(".has-error").each(function() {
            $(this).find('.help-block').remove();
        });

        $('#first_step').find('.form-group').removeClass('has-error');
        $('html, body').animate({ scrollTop: 0 }, 'slow');
        $(".loader-icon").show();

        var adId = $('#ad_id').val();
        var url = adId ? `/save_ads_general/${adId}` : '/save_ads_general';

        $.ajax({
            type: "POST",
            url: url,
            data: form.serialize(),
            dataType: 'json',
            success: function(data) {
                $(".loader-icon").hide();
                if (data.error == 'yes') {
                    let firstErrorFound = false;
                    $.each(data.errors, function(index, item) {
                        if (index == 'categorie_id') {
                            index = 'categorie';
                        }
                        $("#" + index).closest(".form-group").addClass('has-error');
                        $("#" + index).after('<span class="help-block">' + item + '</span>');
                        if (!firstErrorFound) {
                            firstErrorFound = true;
                            $("#" + index).focus();
                            $('html, body').animate({ scrollTop: $("#" + index).offset().top }, 500);
                        }
                    });
                } else if (typeof data.parainage !== "undefined") {
                    $('#alert-message').prepend('<div class="alert alert-warning fade in alert-dismissable" style="margin-top:18px;"><a href="#" class="close" data-dismiss="alert" aria-label="close" title="close">×</a>' + data.parainage + '</div>');
                } else {
                    $('#alert-message').prepend('<div class="alert alert-success fade in alert-dismissable" style="margin-top:18px;"><a href="#" class="close" data-dismiss="alert" aria-label="close" title="close">×</a>' + messages.data_saved + '</div>');
                    location.reload();
                }
            },
            error: function(data) {
                $(".loader-icon").hide();
            }
        });
    }
</script>
@endpush
