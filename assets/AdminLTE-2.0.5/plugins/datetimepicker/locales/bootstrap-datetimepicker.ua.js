 entry_id represents the individual ID number for each of your
entries.</p>
</div>
<div class="section" id="creating-a-trackback-table">
<h3><a class="toc-backref" href="#id6">Creating a Trackback Table</a><a class="headerlink" href="#creating-a-trackback-table" title="Permalink to this headline">¶</a></h3>
<p>Before you can receive Trackbacks you must create a table in which to
store them. Here is a basic prototype for such a table:</p>
<div class="highlight-ci"><div class="highlight"><pre><span></span><span class="nx">CREATE</span> <span class="nx">TABLE</span> <span class="nx">trackbacks</span> <span class="p">(</span>
        <span class="nx">tb_id</span> <span class="nx">int</span><span class="p">(</span><span class="mi">10</span><span class="p">)</span> <span class="nx">unsigned</span> <span class="k">NOT</span> <span class="k">NULL</span> <span class="nx