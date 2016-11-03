@theme @local_fullscreen
Feature: Theme elements appear as expected
    In order to expand the content area
    As a user (e.g. student)
    I need to be able to see the Fullscreen button on a course page
    In order to access quick links
    And as a student or teacher
    I need to be able to see the quick links dropdown menu when I click on my name in the header
    In order to view the footer area
    And as a student or teacher
    I need to be able to expand the footer area by clicking on the footer expander

Background:
    Given the following "users" exist:
        | username    | firstname | lastname | email            | country |
        | student1    | Sam       | Student  | student1@asd.com | GB      |
    And the following "courses" exist:
      | fullname | shortname | category |
      | C1 | C1 | 0 |
    And the following "course enrolments" exist:
      | user | course | role |
      | student1 | C1 | student |

@javascript
Scenario: A user is able to view and use the Fullscreen button
    Given I log in as "student1"
    And I use the clean theme
    And I am on homepage
    Given I follow "C1"
    Then "#fullscreen" "css_element" should exist in the "#region-main" "css_element"
    Given I click on "#fullscreen" "css_element" in the "#region-main" "css_element"
    Then ".fullscreenmode" "css_element" should exist in the "body" "css_element"
    Given I click on "#fullscreen" "css_element" in the "#region-main" "css_element"
    Then ".fullscreenmode" "css_element" should not exist in the "body" "css_element"
