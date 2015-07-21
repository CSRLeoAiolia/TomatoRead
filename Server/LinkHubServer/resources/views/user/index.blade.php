@extends('_layouts.app')

@section('content')
    <div class="ui two column centered grid">
        <div class="column">
            <form id="filterForm" method="get" action="{{url('home')}}">
                <div class="ui fluid icon input">
                    <input type="text" name="keyword" placeholder="输入过滤条件" value="{{$keyword}}">
                    <i class="circular search link icon" id="filterLink"></i>
                </div>
            </form>
        </div>
    </div>


    <div class="ui stackable four column grid">
        <div class="column">
            <table class="ui green table">
                <tbody>
                <tr>
                    <td>
                        <h5 class="ui header">点击次数最多</h5>
                        <p>
                            <div class="ui list">
                            @foreach($links_by_click_count as $link)
                                @include('_layouts.userlink')
                            @endforeach
                            </div>
                        </p>
                    </td>
                </tr>
                </tbody>
            </table>
        </div>
        <div class="column">
            <table class="ui green table">
                <tbody>
                <tr>
                    <td>
                        <h5 class="ui header">最近点击</h5>
                        <p>
                            <div class="ui list">
                            @foreach($links_by_last_click_time as $link)
                                @include('_layouts.userlink')
                            @endforeach
                            </div>
                        </p>
                    </td>
                </tr>
                </tbody>
            </table>
        </div>
        <div class="column">
            <table class="ui green table">
                <tbody>
                <tr>
                    <td>
                        <h5 class="ui header">最近添加</h5>
                        <p>
                            <div class="ui list">
                            @foreach($links_by_created_at as $link)
                                @include('_layouts.userlink')
                            @endforeach
                            </div>
                        </p>
                    </td>
                </tr>
                </tbody>
            </table>
        </div>
        <div class="column">
            <table class="ui green table">
                <tbody>
                <tr>
                    <td>
                        <h5 class="ui header">最不经常点击</h5>
                        <p>
                            <div class="ui list">
                            @foreach($links_not_offen_click as $link)
                                @include('_layouts.userlink')
                            @endforeach
                            </div>
                        </p>
                    </td>
                </tr>
                </tbody>
            </table>
        </div>
    </div>

    <div class="ui stackable four column grid">
        @foreach($groups as $group)
        <div class="column">
            <table class="ui pink table">
                <tbody>
                <tr>
                    <td>
                        <h5 class="ui header">{{$group->name}}</h5>
                        <p>
                            <div class="ui list">
                            @foreach($group->linksKeyword($keyword) as $link)
                                @include('_layouts.userlink')
                            @endforeach
                            </div>
                        </p>
                    </td>
                </tr>
                </tbody>
            </table>
        </div>
        @endforeach
    </div>

    <table class="ui yellow table">
        <tbody>
        <tr>
            <td width="25%">
                @foreach($links_column1 as $link)
                    @include('_layouts.userlink')
                @endforeach
            </td>
            <td width="25%">
                @foreach($links_column2 as $link)
                    @include('_layouts.userlink')
                @endforeach
            </td>
            <td width="25%">
                @foreach($links_column3 as $link)
                    @include('_layouts.userlink')
                @endforeach
            </td>
            <td width="25%">
                @foreach($links_column4 as $link)
                    @include('_layouts.userlink')
                @endforeach
            </td>
        </tr>
        </tbody>
        <tfoot>
        <tr><th colspan="4">
                <div class="ui right floated pagination menu">
                    <a class="item">共计 {{$links_count}} 条链接</a>
                    <a class="item">第 {{$page}} 页</a>
                    <a class="icon item" href="{{url('home').'/?page='.($page - 1 < 1 ? 1 : ($page - 1)).($keyword == '' ? '' : ('&keyword='.$keyword)) }}">
                        <i class="left chevron icon"></i>
                    </a>
                    <a class="icon item" href="{{url('home').'/?page='.($page + 1).($keyword == '' ? '' : ('&keyword='.$keyword))}}">
                        <i class="right chevron icon"></i>
                    </a>
                </div>
            </th>
        </tr></tfoot>
    </table>

    <div class="linkeditmodal ui modal">
        <i class="close icon"></i>
        <div class="header">
            编辑链接
        </div>
        <div class="content">
            <form id="linkeditform" class="ui form" method="post">
                {!! csrf_field() !!}
                <input type="hidden" name="_method" value="PUT">

                <div class="field">
                    <label>标题（简单）</label>
                    <input type="text" name="name" id="linkname">
                </div>
                <div class="field">
                    <label>地址（建议不修改）</label>
                    <input type="text" name="url" id="linkurl">
                </div>
                <div class="field">
                    <label>标签（空格分隔）</label>
                    <input type="text" name="tags" id="linktags">
                    <div class="ui segment">
                        <p id='commonTags'>
                            常用标签：<a>编程</a> <a>C++</a> <a>PHP</a> <a>微信开发</a> <a>Chrome</a><br/>
                            自动提取：<a>编程</a> <a>C++</a> <a>PHP</a> <a>微信开发</a> <a>Chrome</a>
                        </p>
                    </div>
                </div>
                <div class="field">
                    <label>类型</label>
                    <div class="inline fields">
                        <div class="field">
                            <div class="ui radio checkbox">
                                <input type="radio" name="type" tabindex="0" class="hidden linktype" value="0">
                                <label>链接</label>
                            </div>
                        </div>
                        <div class="field">
                            <div class="ui radio checkbox">
                                <input type="radio" name="type" tabindex="0" class="hidden linktype" value="1">
                                <label>公众号</label>
                            </div>
                        </div>
                        <div class="field">
                            <div class="ui radio checkbox">
                                <input type="radio" name="type" tabindex="0" class="hidden linktype" value="2">
                                <label>书籍</label>
                            </div>
                        </div>
                        <div class="field">
                            <div class="ui radio checkbox">
                                <input type="radio" name="type" tabindex="0" class="hidden linktype" value="3">
                                <label>生活</label>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="field">
                    <label>分组</label>
                    <div class="inline fields">
                        <div class="field">
                            <div class="ui radio checkbox">
                                <input type="radio" name="group" tabindex="0" class="hidden linkgroup" value="0">
                                <label>无分组</label>
                            </div>
                        </div>

                        @foreach($groups as $group)
                            <div class="field">
                                <div class="ui radio checkbox">
                                    <input type="radio" name="group" tabindex="0" class="hidden linkgroup" value="{{$group->id}}">
                                    <label>{{$group->name}}</label>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
            </form>
        </div>
        <div class="actions">
            <form method="post" id="deletelinkform">
                {!! csrf_field() !!}
                <input type="hidden" name="_method" value="DELETE"/>
            </form>
            <div class="ui red button" id="deletelinkbutton">
                删除
            </div>
            <div class="ui black deny button">
                取消
            </div>
            <div class="ui positive right labeled icon button" id="submitlinkeditform">
                确定
                <i class="checkmark icon" ></i>
            </div>
        </div>
    </div>

    <div class="linksharemodal ui modal">
        <i class="close icon"></i>
        <div class="header">
            分享
        </div>
        <div class="content">
            share
        </div>
        <div class="actions">
            <div class="ui black deny button">
                取消
            </div>
            <div class="ui positive right labeled icon button">
                分享
                <i class="checkmark icon"></i>
            </div>
        </div>
    </div>

    <div class="linkinfopopup ui popup">
        Hello
    </div>

@endsection


@section('endofbody')
    <script>
        $('#filterLink').click(function () {
            $('#filterForm').submit();
        })

        $('.userlink').click(function () {
            var linkId = $(this).attr('link_id');
            console.log('click:'+ linkId);

            $.post('{{url('api/private/click')}}' + '/' + linkId,
                    function(data,status){
                console.log(data);
            });
        })

        $('.linkpoint').mouseenter(function(){
            $(this).find('.linkmore').show();

        })
        $('.linkpoint').mouseleave(function(){
            $(this).find('.linkmore').hide();

        })
        $('.linkedit').click(function(){
            var linkId = $(this).attr('link_id');
            $('#linkeditform').attr('action','{{url('home/link')}}' + '/' + linkId);

            // delete form
            $('#deletelinkform').attr('action','{{url('home/link')}}' + '/' + linkId);

            $.get('/api/private/linkinfo/' + linkId,function(data,status){
                if(data.result == 'ok'){
                    var l = data.data;
                    $('#linkname').val(l.name);
                    $('#linkurl').val(l.url);
                    $('#linktags').val(l.tags);

                    $('.linktype').each(function(index,element){
                        if($(this).val() == l.type){
                            $(this).attr('checked','');
                        }else{
                            $(this).removeAttr('checked');
                        }
                    });
                    $('.linkgroup').each(function(index,element){
                        console.log('group this val = ' + $(this).val() + ' |vs| group id = ' + l.private_group_id);
                        if($(this).val() == l.private_group_id){
                            $(this).attr('checked','');
                        }else{
                            $(this).removeAttr('checked');
                        }
                    });

                    $('.linkeditmodal.ui.modal')
                            .modal('show')
                    ;
                }else{
                    alert('获取链接信息出错了。');
                }
            })
        })
        $('.linkshare').click(function(){
            $('.linksharemodal.ui.modal')
                    .modal('show')
            ;
        })

        $('#submitlinkeditform').click(function () {
            $('#linkeditform').submit();
        })

        $('#deletelinkbutton').click(function(){
            $('#deletelinkform').submit();
        })


        $(function(){
            $('p#commonTags a').click(function () {
                $('#linktags').val( $('#linktags').val()+ ' ' + $(this).text());
            });
        });


        $('.ui.radio.checkbox')
                .checkbox()
        ;

        $('.linkinfo')
                .popup({
                    setFluidWidth:true
                })
        ;
    </script>
@endsection