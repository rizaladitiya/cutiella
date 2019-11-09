$this</span><span class="o">-&gt;</span><span class="na">uri</span><span class="o">-&gt;</span><span class="na">segment</span><span class="p">(</span><span class="mi">3</span><span class="p">)</span> <span class="o">==</span> <span class="k">FALSE</span><span class="p">)</span>
<span class="p">{</span>
        <span class="nv">$this</span><span class="o">-&gt;</span><span class="na">trackback</span><span class="o">-&gt;</span><span class="na">send_error</span><span class="p">(</span><span class="s1">&#39;Unable to determine the entry ID&#39;</span><span class="p">);</span>
<span class="p">}</span>

<span class="k">if</span> <span class="p">(</span> <span class="o">!</span> <span class="nv">$this</span><span class="o">-&gt;</span><span class="na">trackback</span><span class="o">-&gt;</span><span class="na">receive</span><span class="p">())</span>
<span class="p">{</span>
        <span class="nv">$this</span><span c