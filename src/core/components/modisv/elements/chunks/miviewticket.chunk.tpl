<div class="ticket">
    <h2 class="subject">[[+subject]]</h2>
    <div class="info">
        <span>Topic: [[+topic:ucfirst]]</span>
        <span>Status: [[+status:ucfirst]]</span>
    </div>
    <div class="messages">
        [[+messages]]
    </div>
    [[+status:is=`closed`:then=`
        <div class="activity">The ticket was closed on [[+closedon:strtotime:date=`%Y-%m-%d %H:%M`]].</div>
    `]]
    [[+status:is=`open`:then=`
        <form action="" enctype="multipart/form-data" method="post">
            <h2>Reply to this ticket</h2>
            <fieldset>
                <dl class="body">
                    <dt><label>Body</label></dt>
                    <dd>
                        <textarea name="body">[[+body]]</textarea>
                        <span class="error">[[+error.body]]</span>
                    </dd>
                </dl>
                <dl class="attachments">
                    <dt><label>Attach File</label></dt>
                    <dd>
                        <input type="file" name="files" />
                        <span class="error">[[+error.files]]</span>
                    </dd>
                </dl>
                <dl class="submit">
                    <dt>&nbsp;</dt>
                    <dd><input type="submit" value="Reply" class="btn_a" /></dd>
                </dl>
            </fieldset>
        </form>
    `]]
</div>