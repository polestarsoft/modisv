<div class="new_ticket">
    <form action="[[~[[*id]]]]" enctype="multipart/form-data" method="post">
        [[+error.error_message:is=``:then=``:else=`<span class="error">[[+error.error_message]]</span>` ]]
        <fieldset>
            <dl class="name">
                <dt><label for="name">Name <em>(Optional)</em></label></dt>
                <dd><input type="text" name="name" id="name" value="[[+name]]" /><span class="error">[[+error.name]]</span></dd>
            </dl>
            <dl class="email">
                <dt><label for="email">Email</label></dt>
                <dd><input type="text" name="email" id="email" value="[[+email]]" /><span class="error">[[+error.email]]</span></dd>
            </dl>
            <dl class="subject">
                <dt><label for="subject">Subject <em>(Optional)</em></label></dt>
                <dd><input type="text" name="subject" id="subject" value="[[+subject]]" /><span class="error">[[+error.subject]]</span></dd>
            </dl>
            <dl class="message">
                <dt><label for="body">Message</label></dt>
                <dd><textarea name="body" id="body" value="[[+body]]">[[+body]]</textarea><span class="error">[[+error.body]]</span></dd>
            </dl>
            <dl class="attachments">
                <dt><label>Attach File</label></dt>
                <dd>
                    <input type="file" name="files" />
                    <span class="error">[[+error.files]]</span>
                </dd>
            </dl>
            [[!miCaptcha? &skipMember=`1` &tpl=`
            <dl class="captcha">
                <dt><label for="captcha">Verify Human</label></dt>
                <dd>
                    <div class="question">[[+question]]</div>
                    <input type="text" name="captcha" id="captcha" />
                    <input type="hidden" name="captcha_id" value="[[+id]]" />
                    <div style="font-size:10px">We need to confirm you're human and not a machine trying to post spam.</div>
                    <span class="error">[[+error.captcha]]</span></dd>
            </dl>
            `]]
            <dl class="submit">
                <dt>&nbsp;</dt>
                <dd><input type="submit" value="Send" class="btn_a" /></dd>
            </dl>
        </fieldset>
    </form>
</div>