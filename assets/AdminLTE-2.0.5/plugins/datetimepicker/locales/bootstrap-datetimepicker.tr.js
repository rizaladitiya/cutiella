<span class="na">send</span><span class="p">(</span><span class="nv">$tb_data</span><span class="p">))</span>
<span class="p">{</span>
        <span class="k">echo</span> <span class="nv">$this</span><span class="o">-&gt;</span><span class="na">trackback</span><span class="o">-&gt;</span><span class="na">display_errors</span><span class="p">();</span>
<span class="p">}</span>
<span class="k">else</span>
<span class="p">{</span>
        <span class="k">echo</span> <span class="s1">&#39;Trackback was sent!&#39;</span><span class="p">;</span>
<span class="p">}</span>
</pre></div>
</div>
<p>Description of array data:</p>
<ul class="simple">
<li><strong>ping_url</strong> - The URL 