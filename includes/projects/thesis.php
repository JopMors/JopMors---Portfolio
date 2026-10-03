<?php
/** MASTER-X, the BSc thesis. Content summarised from the thesis itself (assets/docs/thesis-jop-mors.pdf). */

$pdf = asset($project['demo']);

$specs = [
    ['Degree', 'BSc Information Science'],
    ['University', 'Utrecht University'],
    ['Supervisors', 'Dr. ir. C. Di Ciccio · Dr. ir. X. Lu'],
    ['Grade', '8.1 · 15 EC'],
    ['Finished', 'April 2026'],
];

$subQuestions = [
    'Does an immediate skill-match reward beat a delayed completion reward?',
    'Which architecture fits cooperative task assignment: a centralised critic (MAPPO, COMA) or value decomposition (QMIX)?',
    'Which properties of the coordination game decide whether an algorithm converges or fails?',
];

$approach = [
    ['The problem', 'Reinforcement learning for business processes almost always assumes one decision-maker with a complete view. Real processes are run by many people, each seeing only their own corner. A single-agent formulation cannot express who should act, or what it costs when two people reach for the same task.'],
    ['The redesign', 'MASTER-X builds on MASTER, a simulation where every human resource is its own agent. Each agent decides at every step whether to volunteer for the upcoming task. I redesigned the reward so it fires at assignment instead of completion, and gave the agents a skill-advantage signal and a queue-load fraction to observe.'],
    ['The comparison', 'Three algorithms, because they solve credit assignment in three different ways. MAPPO uses a centralised critic with decentralised actors, QMIX uses monotonic value factorisation, and COMA uses a counterfactual baseline. COMA is my addition; the other two came with MASTER.'],
    ['Why it is hard', 'It is a volunteer\'s dilemma. If everyone else volunteers, passing is the rational move for you, because the task gets covered anyway. That equilibrium is stable, it gets more stable as agents are added, and whether an algorithm can break it turns out to be the whole story.'],
];

$environment = [
    ['Environment', 'A decentralised, partially observable process (Dec-POMDP) implemented as a PettingZoo ParallelEnv. Cases become tasks; each step shows the upcoming task to all agents and advances simulated time.'],
    ['Durations', 'Sampled from distributions fitted per agent and activity, not replayed from the log, so a policy can produce outcomes the log never saw.'],
    ['Action', 'Pass or volunteer. The task goes to a random capable volunteer. If nobody volunteers, a capable agent is picked anyway and each capable non-volunteer gets a small penalty, so the process never deadlocks.'],
    ['Observation', 'The task, the agent\'s own mean, median and spread for it, the remaining duration, its queue and busy flag, plus a skill-advantage signal in [−1, 1] and a queue-load fraction.'],
    ['Baselines', 'Random, AlwaysVolunteer and BestMedian, an oracle that always picks the capable agent with the lowest historical median.'],
    ['Output', 'Every policy writes a synthetic event log (case, resource, activity, start, end) that opens directly in process-mining tools such as ProM, Disco or Celonis.'],
];

$datasets = [
    ['Synthetic loan application', '19', '12', '1,000', '7,492'],
    ['BPI Challenge 2012 (W-subprocess)', '52', '6', '8,616', '~150,000'],
];

/** Median-time chart: bars run from 0 to this many minutes. */
$chartMaxMinutes = 20;
$oracleMedian = 15.4;

/** Loan application, task processing time in minutes on the full test split. */
$results = [
    ['Random', '75.6', '18.2', '27.6%', false],
    ['AlwaysVolunteer', '60.0', '18.2', '—', false],
    ['BestMedian (oracle)', '43.0', '15.4', '100% (one agent)', false],
    ['MAPPO', '76.7', '13.4', '61.7%', true],
    ['COMA', '81.0', '17.3', '31.3%', false],
    ['QMIX', '43.0', '12.5', '54.0%', false],
];

$verdicts = [
    ['MAPPO', 'Works', 'Converges within about 15 episodes and closes 65% of the gap between random assignment and the BestMedian oracle — with a median task time of 13.4 minutes against the oracle\'s 15.4, and without dumping every task on one person.'],
    ['COMA', 'Collapses', 'Its counterfactual baseline holds the other agents fixed, so it never breaks the free-riding equilibrium and falls into a degenerate policy. On the larger BPI 2012 log its critic diverges to around 10⁹.'],
    ['QMIX', 'Cannot generalise', 'Its Q-values encode a real preference for faster agents, but it trains on 50-case episodes and is evaluated on 200. The longer episodes saturate the queues of the agents it prefers. A generalisation failure, not a learning failure.'],
];

$takeaways = [
    ['Reward timing comes first', 'With a delayed completion reward, all three algorithms behaved like random assignment. A reward at assignment time is a prerequisite for learning anything at all.'],
    ['A centralised critic is necessary', 'Among the algorithms that do learn, only the one with a centralised critic escaped the volunteer\'s dilemma. It is not merely better; the cooperative structure of the game requires it.'],
    ['Heuristics stay hard to beat', 'BestMedian is fast but routes everything to a handful of people: 6 of 52 resources on BPI 2012. MAPPO spreads work over four people, which makes it far more deployable.'],
];

$stack = ['Python', 'PyTorch', 'PettingZoo', 'Gymnasium', 'pandas', 'SciPy', 'pm4py', 'Matplotlib'];
?>
      <!-- Hero -->
      <section class="px-6 pb-16 pt-36 md:px-12 md:pb-24 md:pt-44">
        <div class="mx-auto max-w-6xl">
          <a href="<?= e(asset('#work')) ?>" class="inline-flex items-center gap-2 text-sm text-m-label link-accent">← All work</a>

          <div class="mt-12 grid items-center gap-16 md:grid-cols-[1.2fr_0.8fr] md:gap-10">
            <div class="min-w-0">
              <div class="flex flex-wrap items-center gap-5" data-reveal>
                <img src="<?= e(asset($project['icon'])) ?>" alt="Utrecht University" width="1290" height="441" class="project-icon project-icon--wide">
                <span class="lg inline-flex items-center gap-2 rounded-full px-4 py-1.5 text-xs font-medium tracking-wide text-m-label">
                  <span class="h-1.5 w-1.5 rounded-full bg-[#30d158]"></span>
                  <?= e(project_status_label($project)) ?>
                </span>
              </div>

              <h1 class="mt-10 text-[19vw] font-semibold leading-[0.85] tracking-[-0.065em] md:text-[min(9vw,8rem)]" data-reveal><?= e($project['title']) ?>.</h1>
              <p class="mt-8 max-w-2xl text-balance text-2xl font-medium leading-snug tracking-[-0.02em] md:text-3xl" data-reveal>
                Advancing Prescriptive Process Monitoring: a Multi-Agent Reinforcement Learning Redesign.
                <span class="text-m-muted">What happens when every person in a business process gets to decide for themselves whether to take the next task?</span>
              </p>

              <div class="mt-10 flex flex-wrap items-center gap-3" data-reveal>
                <a href="<?= e($pdf) ?>" target="_blank" rel="noopener noreferrer" class="inline-flex items-center gap-2 btn-accent rounded-full px-6 py-3 text-sm font-medium transition-transform duration-300 active:scale-[0.97]">Read the thesis (PDF) <?= icon('arrow-up-right') ?></a>
                <a href="<?= e($project['github']) ?>" target="_blank" rel="noopener noreferrer" class="lg lg-press inline-flex items-center gap-2 rounded-full px-6 py-3 text-sm font-medium"><?= icon('github') ?>Code on GitHub</a>
              </div>
            </div>

            <a href="<?= e($pdf) ?>" target="_blank" rel="noopener noreferrer" aria-label="Open the thesis PDF" class="block transition-transform duration-500 hover:-translate-y-1" data-reveal="right">
              <?= paper_stack($project, 'mx-auto w-[min(70vw,320px)] md:mr-0 md:w-[min(28vw,360px)]') ?>
            </a>
          </div>

          <dl class="mt-16 grid grid-cols-2 gap-x-8 gap-y-6 border-t border-m-line/10 pt-8 md:grid-cols-5">
<?php foreach ($specs as [$label, $value]): ?>
            <div>
              <dt class="text-xs font-medium uppercase tracking-[0.18em] text-m-label"><?= e($label) ?></dt>
              <dd class="mt-2 text-lg tracking-tight"><?= e($value) ?></dd>
            </div>
<?php endforeach; ?>
          </dl>
        </div>
      </section>

      <!-- Research question -->
      <section class="px-6 py-24 md:px-12 md:py-36">
        <div class="mx-auto max-w-6xl">
          <?= eyebrow('The question') ?>
          <p class="max-w-5xl text-balance text-4xl font-semibold leading-[1.1] tracking-[-0.04em] md:text-6xl" data-reveal>How do reward design and algorithm architecture affect whether agents <span class="text-m-muted <?= SERIF ?>">learn to share the work well?</span></p>
          <ol class="plain-grid mt-16 grid md:grid-cols-3">
<?php foreach ($subQuestions as $i => $question): ?>
            <li style="--reveal-delay: <?= $i * 0.08 ?>s" data-reveal>
              <span class="font-mono text-sm text-m-muted">RQ<?= $i + 1 ?></span>
              <p class="mt-3 text-lg leading-relaxed text-m-text/85"><?= e($question) ?></p>
            </li>
<?php endforeach; ?>
          </ol>
        </div>
      </section>

      <!-- Approach -->
      <section class="px-6 py-24 md:px-12 md:py-36">
        <div class="mx-auto max-w-6xl">
          <?= eyebrow('The approach') ?>
          <h2 class="max-w-4xl text-5xl font-semibold tracking-[-0.045em] md:text-7xl" data-reveal>One agent <span class="text-m-muted <?= SERIF ?>">per person.</span></h2>
          <div class="plain-grid mt-16 grid md:grid-cols-2">
<?php foreach ($approach as $i => [$title, $body]): ?>
            <div style="--reveal-delay: <?= ($i % 2) * 0.08 ?>s" data-reveal>
              <span class="font-mono text-sm text-m-muted"><?= pad($i + 1) ?></span>
              <h3 class="mt-3 text-2xl font-semibold tracking-[-0.03em]"><?= e($title) ?></h3>
              <p class="mt-3 leading-relaxed text-m-muted"><?= e($body) ?></p>
            </div>
<?php endforeach; ?>
          </div>
        </div>
      </section>

      <!-- How it works -->
      <section class="px-6 py-24 md:px-12 md:py-36">
        <div class="mx-auto grid max-w-6xl gap-14 md:grid-cols-[1fr_1.15fr] md:gap-20">
          <div class="min-w-0">
            <?= eyebrow('Under the hood') ?>
            <h2 class="text-5xl font-semibold tracking-[-0.045em] md:text-6xl" data-reveal>A reward that fires <span class="text-m-muted <?= SERIF ?>">at the right moment.</span></h2>
            <div class="mt-8 space-y-5 text-lg leading-relaxed text-m-muted" data-reveal>
              <p>In MASTER, agents were rewarded when a case completed, often hundreds of steps after the decision that mattered. In MASTER-X the reward fires the moment a task is assigned, based on how fast the chosen agent usually is compared with everyone else:</p>
              <pre class="overflow-x-auto rounded-2xl bg-black/30 px-5 py-4 font-mono text-sm text-m-text">R = −tanh( 2 · (median_agent − median_all) / median_all )</pre>
              <p>A much faster agent earns close to +1, an average one 0 and a much slower one close to −1. It draws on relative performance evaluation, reward shaping and robust medians.</p>
            </div>
          </div>

          <div class="lg self-start rounded-[28px] p-2 md:p-3" data-reveal>
<?php foreach ($environment as $i => [$label, $body]): ?>
            <div class="grid gap-1 px-5 py-4 md:grid-cols-[8rem_1fr] md:gap-6 <?= $i ? 'border-t border-m-line/[0.08]' : '' ?>">
              <span class="font-medium tracking-tight"><?= e($label) ?></span>
              <span class="text-sm leading-relaxed text-m-muted"><?= e($body) ?></span>
            </div>
<?php endforeach; ?>
          </div>
        </div>
      </section>

      <!-- Data -->
      <section class="px-6 py-24 md:px-12 md:py-32">
        <div class="mx-auto max-w-6xl">
          <?= eyebrow('Data') ?>
          <h2 class="text-5xl font-semibold tracking-[-0.045em] md:text-6xl" data-reveal>Two event logs.</h2>
          <p class="mt-6 max-w-2xl text-lg leading-relaxed text-m-muted" data-reveal>A small synthetic process to learn on, and a real one from a Dutch bank to see whether it holds. Training used 50-case episodes, at most 300 of them, with early stopping and a chronological 80/20 split.</p>
          <div class="lg mt-12 rounded-[28px] p-2 md:p-3" data-reveal>
            <div class="hidden grid-cols-[2fr_1fr_1fr_1fr_1fr] gap-6 px-5 py-3 text-xs uppercase tracking-[0.15em] text-m-muted md:grid">
              <span>Event log</span><span>Resources</span><span>Activities</span><span>Traces</span><span>Events</span>
            </div>
<?php foreach ($datasets as $i => [$name, $resources, $activities, $traces, $events]): ?>
            <div class="grid grid-cols-2 gap-x-6 gap-y-1 px-5 py-4 md:grid-cols-[2fr_1fr_1fr_1fr_1fr] <?= $i ? 'border-t border-m-line/[0.08]' : 'md:border-t md:border-m-line/[0.08]' ?>">
              <span class="col-span-2 font-medium tracking-tight md:col-span-1"><?= e($name) ?></span>
              <span class="text-m-muted"><span class="text-m-label md:hidden">Resources </span><?= e($resources) ?></span>
              <span class="text-m-muted"><span class="text-m-label md:hidden">Activities </span><?= e($activities) ?></span>
              <span class="font-mono text-m-muted"><span class="font-sans text-m-label md:hidden">Traces </span><?= e($traces) ?></span>
              <span class="font-mono text-m-muted"><span class="font-sans text-m-label md:hidden">Events </span><?= e($events) ?></span>
            </div>
<?php endforeach; ?>
          </div>
        </div>
      </section>

      <!-- Results -->
      <section class="px-6 py-24 md:px-12 md:py-36">
        <div class="mx-auto max-w-6xl">
          <?= eyebrow('Results') ?>
          <h2 class="text-5xl font-semibold tracking-[-0.045em] md:text-7xl" data-reveal>One works. <span class="text-m-muted <?= SERIF ?>">Two fail, interestingly.</span></h2>

          <div class="mt-16 grid gap-4 md:grid-cols-3">
<?php foreach ($verdicts as $i => [$name, $verdict, $body]): $works = $verdict === 'Works'; ?>
            <div class="lg flex min-h-[18rem] flex-col justify-between rounded-[28px] p-7" style="--reveal-delay: <?= $i * 0.08 ?>s" data-reveal>
              <span class="inline-flex w-fit items-center gap-2 rounded-full bg-m-text/[0.08] px-3 py-1 text-xs <?= $works ? 'text-m-text' : 'text-m-muted' ?>">
                <span class="h-1.5 w-1.5 rounded-full <?= $works ? 'bg-[#30d158]' : 'verdict-dot--fail' ?>"></span>
                <?= e($verdict) ?>
              </span>
              <div>
                <h3 class="text-3xl font-semibold tracking-[-0.03em]"><?= e($name) ?></h3>
                <p class="mt-3 text-sm leading-relaxed text-m-muted"><?= e($body) ?></p>
              </div>
            </div>
<?php endforeach; ?>
          </div>

          <figure class="median-chart" style="--oracle: <?= round($oracleMedian / $chartMaxMinutes * 100, 2) ?>%" data-reveal>
            <figcaption class="text-xs uppercase tracking-[0.15em] text-m-muted">Median task time · loan application, test split · minutes, lower is better</figcaption>
            <div class="median-chart__rows mt-8">
              <div class="median-chart__row median-chart__row--head" aria-hidden="true">
                <span></span>
                <span class="median-chart__track"><span class="median-chart__oracle-label font-mono">oracle <?= e((string) $oracleMedian) ?></span></span>
                <span></span>
              </div>
<?php foreach ($results as [$policy, $mean, $median, $share, $highlight]): ?>
              <div class="median-chart__row">
                <span class="median-chart__label <?= $highlight ? 'text-m-text' : 'text-m-muted' ?>"><?= e($policy) ?></span>
                <span class="median-chart__track"><span class="median-chart__bar<?= $highlight ? ' median-chart__bar--highlight' : '' ?>" style="width: <?= round((float) $median / $chartMaxMinutes * 100, 2) ?>%"></span></span>
                <span class="font-mono text-sm <?= $highlight ? 'text-m-text' : 'text-m-muted' ?>"><?= e($median) ?></span>
              </div>
<?php endforeach; ?>
            </div>
          </figure>

          <details class="exact-numbers mt-10">
            <summary class="text-sm text-m-muted link-accent">Exact numbers</summary>
          <div class="lg mt-4 rounded-[28px] p-2 md:p-3">
            <p class="px-5 pb-2 pt-4 text-xs uppercase tracking-[0.15em] text-m-muted">Loan application · task processing time in minutes, test split</p>
            <div class="hidden grid-cols-[2fr_1fr_1fr_1.4fr] gap-6 border-t border-m-line/[0.08] px-5 py-3 text-xs uppercase tracking-[0.15em] text-m-muted md:grid">
              <span>Policy</span><span>Mean</span><span>Median</span><span>Share of the top two agents</span>
            </div>
<?php foreach ($results as [$policy, $mean, $median, $share, $highlight]): ?>
            <div class="grid grid-cols-3 gap-x-6 gap-y-1 border-t border-m-line/[0.08] px-5 py-4 md:grid-cols-[2fr_1fr_1fr_1.4fr] <?= $highlight ? 'rounded-[18px] bg-m-text/[0.05]' : '' ?>">
              <span class="col-span-3 font-medium tracking-tight md:col-span-1"><?= e($policy) ?></span>
              <span class="font-mono text-m-muted"><span class="font-sans text-m-label md:hidden">Mean </span><?= e($mean) ?></span>
              <span class="font-mono text-m-muted"><span class="font-sans text-m-label md:hidden">Median </span><?= e($median) ?></span>
              <span class="font-mono text-m-muted"><span class="font-sans text-m-label md:hidden">Top two </span><?= e($share) ?></span>
            </div>
<?php endforeach; ?>
          </div>
          </details>
          <p class="mt-6 max-w-3xl px-1 text-sm leading-relaxed text-m-muted">QMIX's numbers look strong here, but it fails at evaluation on longer episodes; see above. On BPI 2012, MAPPO reaches a median of 1.22 minutes against 2.19 for random assignment.</p>
        </div>
      </section>

      <!-- Takeaways -->
      <section class="px-6 py-24 md:px-12 md:py-36">
        <div class="mx-auto max-w-6xl">
          <?= eyebrow('Conclusion') ?>
          <blockquote class="max-w-5xl text-balance text-4xl font-semibold leading-[1.1] tracking-[-0.04em] md:text-7xl" data-reveal>“Reward immediacy matters more than <span class="text-m-muted <?= SERIF ?>">algorithm choice.</span>”</blockquote>
          <div class="mt-16 grid gap-4 md:grid-cols-3">
<?php foreach ($takeaways as $i => [$title, $body]): ?>
            <div class="border-t border-m-line/15 pt-6" style="--reveal-delay: <?= $i * 0.08 ?>s" data-reveal>
              <span class="font-mono text-sm text-m-muted"><?= pad($i + 1) ?></span>
              <h3 class="mt-3 text-2xl font-semibold tracking-[-0.03em]"><?= e($title) ?></h3>
              <p class="mt-3 leading-relaxed text-m-muted"><?= e($body) ?></p>
            </div>
<?php endforeach; ?>
          </div>
          <p class="mt-16 max-w-3xl text-lg leading-relaxed text-m-muted" data-reveal>Future work: curriculum learning with growing episode lengths for QMIX, entropy regularisation or explicit cooperation incentives against COMA's collapse, applying the new reward to the original MASTER, and testing more process shapes.</p>
        </div>
      </section>

      <!-- Read it -->
      <section class="px-3 pb-32 pt-12 md:px-6">
        <div class="lg mx-auto max-w-6xl rounded-[28px] px-6 py-14 md:px-14 md:py-16" data-reveal>
          <div class="grid grid-cols-[minmax(0,1fr)] gap-10 md:grid-cols-[1.1fr_1fr] md:items-end">
            <div class="min-w-0">
              <img src="<?= e(asset($project['icon'])) ?>" alt="" width="1290" height="441" loading="lazy" class="project-icon project-icon--wide">
              <h2 class="mt-8 text-5xl font-semibold tracking-[-0.045em] md:text-7xl">Read the thesis.</h2>
              <p class="mt-4 text-lg text-m-muted">The full text, with the literature review, the research design, every result and the discussion.</p>
            </div>
            <div class="min-w-0">
              <div class="flex flex-wrap items-center gap-3 md:justify-end">
                <a href="<?= e($pdf) ?>" download class="inline-flex items-center gap-2 btn-accent rounded-full px-6 py-3 text-sm font-medium transition-transform duration-300 active:scale-[0.97]">Download PDF <?= icon('arrow-up-right') ?></a>
                <a href="<?= e($project['github']) ?>" target="_blank" rel="noopener noreferrer" class="lg lg-press inline-flex items-center gap-2 rounded-full px-6 py-3 text-sm font-medium"><?= icon('github') ?>Source code</a>
              </div>
              <ul class="mt-5 flex flex-wrap gap-2 md:justify-end">
<?php foreach ($stack as $tech): ?>
                <li class="rounded-full bg-m-text/[0.08] px-3 py-1 text-xs text-m-text/80"><?= e($tech) ?></li>
<?php endforeach; ?>
              </ul>
            </div>
          </div>

          <!-- The PDF itself, on larger screens. Phones open it in their own viewer via the buttons above. -->
          <object data="<?= e($pdf) ?>#view=FitH" type="application/pdf" class="mt-12 hidden h-[85vh] w-full rounded-[20px] bg-white md:block" aria-label="The thesis as a PDF">
            <a href="<?= e($pdf) ?>" class="text-m-text underline">Open the PDF</a>
          </object>
        </div>
      </section>
