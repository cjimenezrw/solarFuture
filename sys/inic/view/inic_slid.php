<?php
/**
 * Created by PhpStorm.
 * User: Jonathan
 * Date: 15/02/2017
 * Time: 04:57 PM
 */
?>

<!-- nav-tabs -->
<ul id="chatSide" class="site-sidebar-nav nav nav-tabs nav-justified nav-tabs-line" data-plugin="nav-tabs"
    role="tablist">
    <li class="active" role="presentation">
        <a data-toggle="tab" href="#sidebar-userlist" role="tab">
            <i class="icon wb-chat" aria-hidden="true"></i>
        </a>
    </li>
    <li role="presentation" class="hidden">
        <a data-toggle="tab" href="#sidebar-activity" role="tab">
            <i class="icon wb-list-bulleted" aria-hidden="true"></i>
        </a>
    </li>
    <li role="presentation" class="hidden">
        <a data-toggle="tab" href="#sidebar-setting" role="tab">
            <i class="icon wb-settings" aria-hidden="true"></i>
        </a>
    </li>
</ul>

<div class="site-sidebar-tab-content tab-content">
    <div class="tab-pane fade active in" id="sidebar-userlist">
        <div>
            <div>
                <h5 class="clearfix">LISTA DE USUARIOS <span id="connectedCount"></span>
                    <div class="pull-right">
<!--                        <a class="text-action" href="javascript:void(0)" role="button">
                            <i class="icon wb-plus" aria-hidden="true"></i>
                        </a>
                        <a class="text-action" href="javascript:void(0)" role="button">
                            <i class="icon wb-more-horizontal" aria-hidden="true"></i>
                        </a>-->
                    </div>
                </h5>
                <div class="margin-vertical-20" role="search">
                    <div class="input-search input-search-dark">
                        <i class="input-search-icon wb-search" aria-hidden="true"></i>
                        <input type="text" class="form-control" id="inputSearch" name="search"
                               placeholder="Buscar Usuario" onkeyup="chat_filter(this)">
                        <button type="button" class="input-search-close icon wb-close" aria-label="Close" onclick="$('#inputSearch').val(''); chat_filter('');"></button>
                    </div>
                </div>

                <div class="list-group contacts">

                </div>

            </div>
        </div>
    </div>

    <div class="tab-pane fade" id="sidebar-activity">
        <div>
            <div>
                <h5>ACTIVIDAD RECIENTE</h5>
                <ul class="timeline timeline-icon timeline-single timeline-simple timeline-feed">

                </ul>
            </div>
        </div>
    </div>

    <div class="tab-pane fade" id="sidebar-setting">
        <div>
            <div>
                <h5>AJUSTES DE NOTIFICACIONES</h5>
                <ul class="list-group noti_settings">

                </ul>
            </div>
        </div>
    </div>
</div>

<div id="conversation" class="conversation">
    <div class="conversation-header">
        <a class="conversation-more pull-right" href="javascript:void(0)">
            <i class="icon wb-more-horizontal" aria-hidden="true"></i>
        </a>
        <a class="conversation-return pull-left" onclick="core.skUserChat = '';" href="javascript:void(0)" data-toggle="close-chat">
            <i class="icon wb-chevron-left" aria-hidden="true"></i>
        </a>

        <div class="conversation-title"></div>
    </div>
    <div class="chats chats-slide">

    </div>
    <div class="conversation-reply">
        <div class="input-group">
      <span class="input-group-btn">
        <a href="javascript: void(0)" class="btn btn-pure btn-default icon wb-plus" style="opacity: 0.0"></a>
      </span>
            <textarea data-emojiable="true" class="form-control messageInput" type="text" placeholder="Mensaje..." data-plugin="maxlength" maxlength="500" style="resize: none"></textarea>
      <span class="input-group-btn">
        <button id="sendMessageChat" onclick="sendMessage();" class="btn btn-pure btn-default fa fa-paper-plane-o"></button>
      </span>
        </div>
    </div>
</div>

<div id="popUp-user-details"></div>

<script src="<?php echo SYS_URL; ?><?php echo $this->sysProject; ?>/inic/view/js/<?php echo VERSION; ?>/slid.js"></script>