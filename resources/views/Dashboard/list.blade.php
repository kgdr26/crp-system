@extends('main')
@section('content')

    <section class="section dashboard">
        <div class="row align-items-top">
            <div class="col-3">
                <div class="card">
                    <div class="card-header">
                        <div class="d-flex justify-content-between">
                            <span>Form</span>
                        </div>
                    </div>
                    <div class="card-body">
                        <div class="mb-3 mt-3">
                            <label for="" class="form-label">Activity CRP</label>
                            <textarea name="" class="form-control" id="" rows="5" data-name="activity"></textarea>
                        </div>

                        <div class="mb-3">
                            <label for="" class="form-label">Tanggal</label>
                            <input type="text" class="form-control" id="" data-name="date">
                        </div>

                        <div class="mb-3">
                            <label for="" class="form-label">Value</label>
                            <input type="number" class="form-control" id="" data-name="value">
                        </div>

                        <div class="mb-3">
                            <button type="button" class="btn btn-primary" data-name="save_data">Save</button>
                            <button type="button" class="btn btn-secondary" data-name="reset_data">Reset</button>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-9">
                <div class="card">
                    <div class="card-header">
                        <div class="d-flex justify-content-between">
                            <span>Chart</span>
                        </div>
                    </div>
                    <div class="card-body">
                        <figure class="highcharts-figure">
                            <div id="activity_chart"></div>
                        </figure>
                    </div>
                </div>
            </div>
        </div>
    </section>

@stop
