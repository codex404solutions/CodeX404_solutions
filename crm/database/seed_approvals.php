<?php
declare(strict_types=1);

/**
 * CodeX404 Solutions — Seed Approval Queue with Initial AI Agent Workflows
 * Staging sample outbound email drafts and LinkedIn/X social posts for founder review.
 */

namespace CRM;

use CRM\Services\StorageService;
use CRM\Services\ApprovalService;

require_once __DIR__ . '/app/Services/StorageService.php';
require_once __DIR__ . '/app/Services/ApprovalService.php';

StorageService::init(__DIR__ . '/storage');

// 1. Sample LinkedIn Growth Post
ApprovalService::submit(
    'social_post',
    'LinkedIn Thought Leadership: Why Custom Web Apps Beat Monolithic Builders',
    [
        'platform' => 'LinkedIn / X (Twitter)',
        'content' => "Most growing US businesses hit a ceiling with off-the-shelf site builders around $1M ARR.\n\nSlow load times, rigid data schemas, and API rate limits start choking customer acquisition.\n\nAt CodeX404 Solutions, we replace legacy bottlenecks with high-performance, tailored web architectures built to scale.\n\nWhat's the #1 performance bottleneck in your current tech stack? Let's discuss in the comments 👇\n\n#WebDevelopment #SaaS #CustomSoftware #CodeX404",
        'scheduled_date' => date('Y-m-d', strtotime('+1 day'))
    ],
    'Growth Marketer Agent'
);

// 2. Sample Outbound Strategic Email Draft
ApprovalService::submit(
    'email_draft',
    'Outreach to US Logistics SaaS Prospect (Acme Freight)',
    [
        'to' => 'cto@acmefreight-example.com',
        'subject' => 'Performance architecture for Acme Freight portal',
        'body' => "Hi David,\n\nI noticed your customer portal loads dispatch metrics with noticeable latency during peak morning hours.\n\nOur team at CodeX404 Solutions specializes in optimizing high-throughput React/Next.js and backend caching layers for US logistics leaders.\n\nWould you be open to a 15-minute technical audit next week?\n\nBest,\nMuhammad Noukhez\nFounder, CodeX404 Solutions"
    ],
    'Sales Engineer Agent'
);

echo "Successfully seeded approval queue with initial AI agent drafts.\n";
