Feature: Env
  Background:
    Given a context file "features/bootstrap/FeatureContext.php" containing:
        """
        <?php
        use Behat\Behat\Context\Context;
        class FeatureContext implements Context
        {
            public function __construct(string $key) {
              $this->key = $key;
            }

            /** @Then it passes */
            public function itPasses() {}
            /** @Then it fails */
            public function itFails() { throw new \RuntimeException(); }
            /** @Then it prints env */
            public function itPassesWithOutput() { echo $this->key; }
            /** @Then it fails with output :output */
            public function itFailsWithOutput($output) { throw new \RuntimeException($output); }
        }
        """

  Scenario: Pass Behat if no .env file exists
    Given a feature file with passing scenario
    And a Behat configuration containing:
        """
        default:
            extensions:
                Tourstream\Behat\EnvironmentExtension: ~
        """
    When I run Behat
    Then it should pass with:
        """
        1 scenario (1 passed)
        1 step (1 passed)
        """

  Scenario: Replace env variables
    Given a Behat configuration containing:
        """
        default:
            suites:
              default:
                contexts:
                  - FeatureContext:
                      key: '%env(FOOBAR)%'
            extensions:
                Tourstream\Behat\EnvironmentExtension: ~
        """
    And  a file ".env" containing "FOOBAR=FOO"
    And a feature file "features/passing_scenario.feature" containing:
        """
        Feature: Passing feature
            Scenario: Passing scenario
                Then it prints env
        """
    When I run Behat
    Then it should pass with "FOO"
    Then it should pass with:
        """
        1 scenario (1 passed)
        1 step (1 passed)
        """