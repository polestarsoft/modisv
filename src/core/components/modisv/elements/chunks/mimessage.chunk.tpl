<div class="message">
    <h5 class="header [[+classes]]">
        <a name="[[+id]]"></a>
        <a class="num" href="#[[+id]]">[[+number]]</a>
        <span class="info">[[+number:is=`1`:then=`Created`:else=`Posted`]] by <b>[[+author_name:empty=`[[+author_email]]`]]</b> on [[+createdon:strtotime:date=`%Y-%m-%d %H:%M`]]</span>
    </h5>
    <img class="avatar" src="[[+gravatar_url]]?s=32&d=identicon" />
    <div class="content wmd">
        [[+html_body]]
        [[+attachments:is=``:then=``:else=`
            <div class="attachments">[[+attachments]]</div>
        `]]
    </div>
</div>