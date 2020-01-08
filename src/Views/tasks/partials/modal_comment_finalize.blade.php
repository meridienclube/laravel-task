@modal($data)
{!! Form::open(['route' => ['tasks.close', $task->id], 'method' => 'post', 'class' => 'formModalCommentFinalize horizontal-form', 'id' => $data['id']]) !!}
<div class="row">
    <div class="form-group col-md-12">
        <label class="control-label">{{ trans('meridien.Para concluir a tarefa insira um comentário') }}<span class="">*</span></label>
        {!! Form::textarea('comment', null, ['class' => 'form-control', 'placeholder' => 'Digite um comentário para finalizar esta tarefa', 'required']) !!}
    </div>
</div>
{!! Form::close() !!}

@push('scripts')
    <script>
        $("#formModalCommentFinalize").submit(function() {
            var form = $(this);
            console.log(form.find('textarea').required)
            console.log(form);
        });
    </script>
@endpush

@endmodal
