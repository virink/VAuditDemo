    <div class="span2">
    </div>
    <div class="span10">
        <div id="content">
			<div class="page-header">
                <h4>关于 VAuditDemo</h4>
                <hr>
				<p>
                    <b>[测试环境]</b>
                    <br />
					<ul>
                        <li><?=strtr(explode(" ",$_SERVER["SERVER_SOFTWARE"])[0],"/"," ")?></li>
						<li>PHP <?=PHP_VERSION?></li>
					</ul>
                    <b>[php配置文件中]</b>
                    <br />
					<ul>
                        <li>allow_url_include = <?=ini_get('allow_url_include')?'On':'Off'?></li>
                        <li>allow_url_fopen = <?=ini_get('allow_url_fopen')?'On':'Off'?></li>
                        <li>magic_quotes_gpc = <?=ini_get('magic_quotes_gpc')?'On':'Off'?></li>
					</ul>
                </p>
                <hr>
                <p>
                    <b>[联系]</b>
                    <br />
                    Telegram: <a href="https://telegram.me/virink">@virink</a>
                    <br />
                    Email: virink@outlook.com
                    <br />
					欢迎一起交流学习
                </p>    
            </div>
        </div>
    </div>
